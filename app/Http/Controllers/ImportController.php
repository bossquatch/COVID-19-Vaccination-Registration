<?php

namespace App\Http\Controllers;

use App\Imports\FLShotsImport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ImportController extends Controller
{

	public function flShots($file)
	{

		try {
			Excel::import(new FLShotsImport, $file,'local');
		} catch (\Throwable $e) {
			report ($e);
			return false;
		}

		return true;
	}

}
