<?php

namespace App\Exports;

use App\Models\Registration;
use Maatwebsite\Excel\Excel;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\Exportable;
use PhpOffice\PhpSpreadsheet\Cell\Cell;
use PhpOffice\PhpSpreadsheet\Cell\DataType;
use Maatwebsite\Excel\Concerns\WithCustomValueBinder;
use PhpOffice\PhpSpreadsheet\Cell\DefaultValueBinder;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;


class EventReport implements FromView, Responsable, WithColumnFormatting
{
    use Exportable;

    /**
    * It's required to define the fileName within
    * the export class when making use of Responsable.
    */
    private $fileName = 'COVID19VaccinationReport.xlsx';
    
    /**
    * Optional Writer Type
    */
    private $writerType = Excel::XLSX;
    
    /**
    * Optional headers
    */
    private $headers = [
        'Content-Type' => 'text/csv',
    ];

    /**
    * Required vars to pass into construct
    */
    protected $event_id;
    protected $event_date;

    public function __construct(int $event_id, $event_date)
    {
        $this->event_date = $event_date;
        $this->event_id  = $event_id;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function view(): View
    {
        $registrations_vaccine = Registration::with([
                'vaccines' => function ($query) {
                    $query->where('date_given', '=', $this->event_date);
                },
                'address', 'vaccines.risk_factors', 'vaccines.vaccine_type', 'vaccines.eligibility', 'vaccines.injection_route', 'vaccines.injection_site', 'vaccines.manufacturer'
            ])->whereHas('vaccines', function ($query) {
                $query->where('date_given', '=', $this->event_date);
            })->whereHas('invitations', function ($query) {
                $query->whereHas('slot', function ($query) {
                    $query->where('event_id', '=', $this->event_id);
                });
            })->get();

            /*
        $registrations_no_vaccine = Registration::with('address')
            ->whereDoesntHave('vaccines', function ($query) {
                $query->where('date_given', '=', $this->event_date);
            })->whereHas('invitations', function ($query) {
                $query->whereHas('slot', function ($query) {
                    $query->where('event_id', '=', $this->event_id);
                })->where('invite_status_id', 10);
            })->get();
            */

        return view('exports.events.report', [
            'registrations_vaccine' => $registrations_vaccine,
            //'registrations_no_vaccine' => $registrations_no_vaccine,
            'date' => $this->event_date,
        ]);
    }

    /*
    public function bindValue(Cell $cell, $value)
    {
        $cell->setValueExplicit($value, DataType::TYPE_INLINE);

        return true;
    }
    */

    public function columnFormats(): array
    {
        return [
            'M' => 'mm/dd/yyyy',
            'Q' => '00000000000',
            'R' => 'mm/yyyy',
            'S' => 'mm/dd/yyyy',
        ];
    }

}
