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

class AllList implements FromView, Responsable, WithColumnFormatting
{
    use Exportable;

    /**
    * It's required to define the fileName within
    * the export class when making use of Responsable.
    */
    private $fileName = 'EventAllList.xlsx';

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
    protected $event;

    public function __construct(\App\Models\Event $event)
    {
        $this->event = $event;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function view(): View
    {
        $invitations = $this->event->invitations()->with(['registration', 'registration.user', 'registration.address', 'registration.address.state', 'registration.contacts'])->get();

        return view('exports.events.all', [
            'invites' => $invitations,
            'event' => $this->event
        ]);
    }

    public function columnFormats(): array
    {
        return [

        ];
    }

}
