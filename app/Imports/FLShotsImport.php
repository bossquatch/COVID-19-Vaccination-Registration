<?php


namespace App\Imports;

use App\Models\ShotRecord;
use Illuminate\Contracts\Queue\ShouldQueue;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithUpserts;

class FLShotsImport implements ToModel, WithBatchInserts, WithHeadingRow, WithChunkReading, WithUpserts, ShouldQueue
{

	public function model(array $row)
	{

		dd($row[0]);

		return new ShotRecord([
			'immid'                 => $row[0],
			'name_last'             => $row[1],
			'name_first'            => $row[2],
			'name_middle'           => $row[3],
			'date_birth'            => $row[4],
			'address_1'             => $row[8],
			'locality'              => $row[9],
			'state'                 => $row[10],
			'postal_code'           => $row[11],
			'county'                => $row[12],
			'phone'                 => $row[13],
			'email'                 => $row[14],
			'vaccine'               => $row[18],
			'date_given'            => $row[21],
			'lot_number'            => $row[22],
			'expiry_date'           => $row[23],
			'provider_org'          => $row[27],
			'provider_site'         => $row[30],
			'provider_site_county'  => $row[34],
			'provider_type'         => $row[35],
			'risk_factor'           => $row[36],
			'vaccinator'            => $row[37],
			'date_entered'          => $row[38],
			'dose_number'           => $row[40],
		]);

	}

	public function batchSize(): int
	{
		return 10;
	}

	public function uniqueBy(): string
	{
		return 'immid';
	}

	public function chunkSize(): int
	{
		return 10;
	}
}
