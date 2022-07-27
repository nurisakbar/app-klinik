<?php
Class FunctionsCore {

	public function __construct() {
	    $this->_ci =& get_instance();
	}

	/**
	* This function gets a list of formated groups and ledgers according to the entrytype label
	* and Search Term for Select2 dropdown plugin.
	**/
	public function ledgerList($entrytypeLabel, $searchTerm = null, $selectedLedgers = array()) {

		// if ($this->input->post('searchTerm')) {
		// 	$searchTerm = $this->input->post('searchTerm');
		// }
		
		// Select from entrytypes table in DB1 where label = $entrytypeLabel
		$entrytype = $this->_ci->DB1->query("SELECT * FROM ".$this->_ci->DB1->dbprefix('entrytypes')." WHERE label='$entrytypeLabel'");
		// create array of select data from DB1 - [entrytypes] table
		$entrytype = $entrytype->row_array();


		/* Ledger selection */
		$ledgers = new LedgerTree(); // initilize ledgers array - LedgerTree Lib
		$ledgers->Group = &$this->Group; // initilize selected ledger groups in ledgers array
		$ledgers->Ledger = &$this->Ledger; // initilize selected ledgers in ledgers array
		$ledgers->for = 'select2';
		$ledgers->searchTerm = $searchTerm;
		$ledgers->current_id = -1; // initilize current group id
		// set restriction_bankcash from entrytype
		$ledgers->restriction_bankcash = $entrytype['restriction_bankcash'];
		$ledgers->build(0); // set ledger id to [NULL] and ledger name to [None]
		$ledgers->toList($ledgers, -1); // create a list of ledgers array
		$ledger_options = $ledgers->ledgerList; // pass ledger list to view page

		foreach ($ledger_options as $key => $value) {
			if ($key < 0) {
				$disabled = true;
			} else {
				$disabled = false;
			}
			$selected = null;
			if (is_array($selectedLedgers)) {
				foreach ($selectedLedgers as $ledgerID) {
					if ($key == $ledgerID) {
						$selected = true;
						break;
					} else {
						$selected = false;
					}
				}
			}

			$results[] = array('id' => $key, 'text' => $value, 'disabled' => $disabled, 'selected' => $selected);
		}

		return $this->send_json($results);
	}

	/**
	* This function returns the ledger or group name with code if present
	**/
	function toCodeWithName($code, $name) {
		if (empty($code)) {
			return $name;
		} else {
			return '[' . $code . '] ' . $name;
		}
	}
	function kodeLedger($code, $name) {
		if (empty($code)) {
			return $name;
		} else {
			return '[' . $code . '] ';
		}
	}

	function namaLedger($code, $name) {
		if (empty($code)) {
			return $name;
		} else {
			return $name;
		}
	}

	/**
	* This function counts the number of decimal places in a given amount
	**/
	function countDecimal($amount) {
		return strlen(substr(strrchr($amount, "."), 1));
	}
	
	/**
	* This function converts the date and time string to valid SQL datetime value
	**/
	function dateToSql($indate) {
		$unixTimestamp = strtotime($indate . ' 00:00:00');
		if (!$unixTimestamp) {
			return false;
		}
		return date("Y-m-d", $unixTimestamp);
	}

	/**
	* This function converts the SQL datetime value to PHP date and time string
	**/
	function dateFromSql($sqldate) {
		$unixTimestamp = strtotime($sqldate . ' 00:00:00');
		if (!$unixTimestamp) {
			return false;
		}
		return date($this->_ci->mDateArray[0], $unixTimestamp);
	}

	/**
 	* This function formats the entry number as per prefix, suffix and zero
	* padding for that entry type
	**/
	function toEntryNumber($number, $entrytype_id)
	{
		$this->_ci->DB1->where('entrytypes.id', $entrytype_id);
		$row = $this->_ci->DB1->get('entrytypes')->row();
		if ($row->zero_padding > 0) {
			return $row->prefix.str_pad($number, $row->zero_padding, '0', STR_PAD_LEFT).$row->suffix;
		} else {
			return $row->prefix.$number.$row->suffix;
		}
	}

	/**
	* This function formats the amount to currency using it's type i.e. debit ot credit
	**/

	/* ============= function toCurrency Asli ===========================
	function toCurrency($dc, $amount) {

		$decimal_places = $this->_ci->mAccountSettings->decimal_places;

		if ($this->calculate($amount, 0, '==')) {
			return $this->curreny_format(number_format(0, $decimal_places, '.', ''));
		}

		if ($dc == 'D') {
			if ($this->calculate($amount, 0, '>')) {
				return 'Dr ' . $this->curreny_format(number_format($amount, $decimal_places, '.', ''));
			} else {
				return 'Cr ' . $this->curreny_format(number_format($this->calculate($amount, 0, 'n'), $decimal_places, '.', ''));
			}
		} else if ($dc == 'C') {
			if ($this->calculate($amount, 0, '>')) {
				return 'Cr ' . $this->curreny_format(number_format($amount, $decimal_places, '.', ''));
			} else {
				return 'Dr ' . $this->curreny_format(number_format($this->calculate($amount, 0, 'n'), $decimal_places, '.', ''));
			}
		} else if ($dc == 'X') {
			// Dr for positive and Cr for negative value 
			if ($this->calculate($amount, 0, '>')) {
				return 'Dr ' . $this->curreny_format(number_format($amount, $decimal_places, '.', ''));
			} else {
				return 'Cr ' . $this->curreny_format(number_format($this->calculate($amount, 0, 'n'), $decimal_places, '.', ''));
			}
		} else {
			return $this->curreny_format(number_format($amount, $decimal_places, '.', ''));
		}
		return lang('error');
	} */

	function toCurrency($dc, $amount) {

		$decimal_places = $this->_ci->mAccountSettings->decimal_places;

		if ($this->calculate($amount, 0, '==')) {
			return $this->curreny_format(number_format(0, $decimal_places, '.', ''));
		}

		if ($dc == 'D') {
			if ($this->calculate($amount, 0, '>')) {
				return ' ' . $this->curreny_format(number_format($amount, $decimal_places, '.', ''));
			} else {
				return ' ' . $this->curreny_format(number_format($this->calculate($amount, 0, 'n'), $decimal_places, '.', ''));
			}
		} else if ($dc == 'C') {
			if ($this->calculate($amount, 0, '>')) {
				return ' ' . $this->curreny_format(number_format($amount, $decimal_places, '.', ''));
			} else {
				return ' ' . $this->curreny_format(number_format($this->calculate($amount, 0, 'n'), $decimal_places, '.', ''));
			}
		} else if ($dc == 'X') {
			// Dr for positive and Cr for negative value 
			if ($this->calculate($amount, 0, '>')) {
				return ' ' . $this->curreny_format(number_format($amount, $decimal_places, '.', ''));
			} else {
				return ' ' . $this->curreny_format(number_format($this->calculate($amount, 0, 'n'), $decimal_places, '.', ''));
			}
		} else {
			return $this->curreny_format(number_format($amount, $decimal_places, '.', ''));
		}
		return lang('error');
	} 

	function calculate($param1 = 0, $param2 = 0, $op = '') {

		$decimal_places = $this->_ci->mAccountSettings->decimal_places;

		if (extension_loaded('bcmath')) {
			switch ($op)
			{
				case '+':
					return bcadd($param1, $param2, $decimal_places);
					break;
				case '-':
					return bcsub($param1, $param2, $decimal_places);
					break;
				case '==':
					if (bccomp($param1, $param2, $decimal_places) == 0) {
						return TRUE;
					} else {
						return FALSE;
					}
					break;
				case '!=':
					if (bccomp($param1, $param2, $decimal_places) == 0) {
						return FALSE;
					} else {
						return TRUE;
					}
					break;
				case '<':
					if (bccomp($param1, $param2, $decimal_places) == -1) {
						return TRUE;
					} else {
						return FALSE;
					}
					break;
				case '>':
					if (bccomp($param1, $param2, $decimal_places) == 1) {
						return TRUE;
					} else {
						return FALSE;
					}
					break;
				case '>=':
					$temp = bccomp($param1, $param2, $decimal_places);
					if ($temp == 1 || $temp == 0) {
						return TRUE;
					} else {
						return FALSE;
					}
					break;
				case 'n':
					return bcmul($param1, -1, $decimal_places);
					break;
				default:
					die();
					break;
			}
		} else {
			$result = 0;

			if ($decimal_places == 2) {
				$param1 = $param1 * 100;
				$param2 = $param2 * 100;
			} else if ($decimal_places == 3) {
				$param1 = $param1 * 1000;
				$param2 = $param2 * 1000;
			}

			$param1 = (int)round($param1, 0);
			$param2 = (int)round($param2, 0);
			switch ($op)
			{
				case '+':
					$result = $param1 + $param2;
					break;
				case '-':
					$result = $param1 - $param2;
					break;
				case '==':
					if ($param1 == $param2) {
						return TRUE;
					} else {
						return FALSE;
					}
					break;
				case '!=':
					if ($param1 != $param2) {
						return TRUE;
					} else {
						return FALSE;
					}
					break;
				case '<':
					if ($param1 < $param2) {
						return TRUE;
					} else {
						return FALSE;
					}
					break;
				case '>':
					if ($param1 > $param2) {
						return TRUE;
					} else {
						return FALSE;
					}
					break;
				case '>=':
					if ($param1 >= $param2) {
						return TRUE;
					} else {
						return FALSE;
					}
					break;
				case 'n':
					$result = -$param1;
					break;
				default:
					die();
					break;
			}

			if ($decimal_places == 2) {
				$result = $result/100;
			} else if ($decimal_places == 3) {
				$result = $result/100;
			}

			return $result;
		}
	}

	/**
	 * Perform a calculate with Debit and Credit Values
	 *
	 * @param1 float number 1
	 * @param2 char number 1 debit or credit
	 * @param3 float number 2
	 * @param4 float number 2 debit or credit
	 * @return array() result of the operation
	*/
	function calculate_withdc($param1, $param1_dc, $param2, $param2_dc) {
		$result = 0;
		$result_dc = 'D';

		if ($param1_dc == 'D' && $param2_dc == 'D') {
			$result = $this->calculate($param1, $param2, '+');
			$result_dc = 'D';
		} else if ($param1_dc == 'C' && $param2_dc == 'C') {
			$result = $this->calculate($param1, $param2, '+');
			$result_dc = 'C';
		} else {
			if ($this->calculate($param1, $param2, '>')) {
				$result = $this->calculate($param1, $param2, '-');
				$result_dc = $param1_dc;
			} else {
				$result = $this->calculate($param2, $param1, '-');
				$result_dc = $param2_dc;
			}
		}

		return array('amount' => $result, 'dc' => $result_dc);
	}


	/**
	 * This function formats the currency as per the currency format in account settings
	 *
	 * $input format is xxxxxxx.xx
	 */
	function curreny_format($input) {
		switch ($this->_ci->mAccountSettings->currency_format) {
			case 'none':
				return $input;
			case '##,###.##':
				return $this->_currency_2_3_style($input);
				break;
			case '##,##.##':
				return $this->_currency_2_2_style($input);
				break;
			case "###,###.##":
				return $this->_currency_3_3_style($input);
				break;
			default:
				die("Invalid curreny format selected.");
		}
	}

	/*********************** ##,###.## FORMAT ***********************/
	function _currency_2_3_style($num)
	{
		$decimal_places = $this->_ci->mAccountSettings->decimal_places;


		$pos = strpos((string)$num, ".");
		if ($pos === false) {
			if ($decimal_places == 2) {
				$decimalpart = "00";
			} else {
				$decimalpart = "000";
			}
		} else {
			$decimalpart = substr($num, $pos + 1, $decimal_places);
			$num = substr($num, 0, $pos);
		}

		if (strlen($num) > 3) {
			$last3digits = substr($num, -3);
			$numexceptlastdigits = substr($num, 0, -3 );
			$formatted = $this->_currency_2_3_style_makecomma($numexceptlastdigits);
			$stringtoreturn = $formatted . "," . $last3digits . "." . $decimalpart ;
		} elseif (strlen($num) <= 3) {
			$stringtoreturn = $num . "." . $decimalpart;
		}

		if (substr($stringtoreturn, 0, 2) == "-,") {
			$stringtoreturn = "-" . substr($stringtoreturn, 2);
		}
		return $stringtoreturn;
	}

	function _currency_2_3_style_makecomma($input)
	{
		if (strlen($input) <= 2) {
			return $input;
		}
		$length = substr($input, 0, strlen($input) - 2);
		$formatted_input = $this->_currency_2_3_style_makecomma($length) . "," . substr($input, -2);
		return $formatted_input;
	}

	/*********************** ##,##.## FORMAT ***********************/
	function _currency_2_2_style($num)
	{
		$decimal_places = $this->_ci->mAccountSettings->decimal_places;


		$pos = strpos((string)$num, ".");
		if ($pos === false) {
			if ($decimal_places == 2) {
				$decimalpart = "00";
			} else {
				$decimalpart = "000";
			}
		} else {
			$decimalpart = substr($num, $pos + 1, $decimal_places);
			$num = substr($num, 0, $pos);
		}

		if (strlen($num) > 2) {
			$last2digits = substr($num, -2);
			$numexceptlastdigits = substr($num, 0, -2);
			$formatted = _currency_2_2_style_makecomma($numexceptlastdigits);
			$stringtoreturn = $formatted . "," . $last2digits . "." . $decimalpart;
		} elseif (strlen($num) <= 2) {
			$stringtoreturn = $num . "." . $decimalpart ;
		}

		if (substr($stringtoreturn, 0, 2) == "-,") {
			$stringtoreturn = "-" . substr($stringtoreturn, 2);
		}
		return $stringtoreturn;
	}

	function _currency_2_2_style_makecomma($input)
	{
		if (strlen($input) <= 2) {
			return $input;
		}
		$length = substr($input, 0, strlen($input) - 2);
		$formatted_input = _currency_2_2_style_makecomma($length) . "," . substr($input, -2);
		return $formatted_input;
	}

	/*********************** ###,###.## FORMAT ***********************/
	function _currency_3_3_style($num)
	{
		$decimal_places = $this->_ci->mAccountSettings->decimal_places;
		return number_format($num,$decimal_places,',','.');
	}

	/**
	 * Helper method to return the tag
	 */
	function showTag($id) {
		if (empty($id)) {
			return '-';
		}
		$this->_ci->DB1->where('id', $id);
		$tag = $this->_ci->DB1->get('tags')->row_array();

		return '<span class="tag" style="color:#' . ($tag['color']) .
			'; background-color:#' . ($tag['background']) . ';"><span style="color: #'.$tag['color'].';">' .$tag['title']. '</span></span>';
	}

	/**
	 * Show the entry ledger details
	 */
	function entryLedgers($id) {
		$this->_ci->load->model('Entry_model');
		/* Load the Entry model */
		$Entry = new Entry_model();
		return $Entry->entryLedgers($id);
	}
	function namaAkun($id) {
		$this->_ci->load->model('Entry_model');
		/* Load the Entry model */
		$Entry = new Entry_model();
		return $Entry->namaAkun($id);
	}

	function kodeAkun($id) {
		$this->_ci->load->model('Entry_model');
		/* Load the Entry model */
		$Entry = new Entry_model();
		return $Entry->kodeAkun($id);
	}

	public function generate_pdf($content, $name = 'download.pdf', $output_type = null, $footer = null, $margin_bottom = null, $header = null, $margin_top = null, $orientation = 'P') {
        // $this->load->library('wf_wkhtmlto', '', 'pdf');
        $this->_ci->load->library('Pdf', '', 'pdf');
        return $this->_ci->pdf->generate($content, $name, $output_type, $footer, $margin_bottom, $header, $margin_top, $orientation);
    }

	// public function generate_pdf($content, $name = 'download.pdf', $output_type = null, $footer = null, $margin_bottom = null, $header = null, $margin_top = null, $orientation = 'L')
 //    {
 //        if (!$output_type) {
 //            $output_type = 'D';
 //        }
 //        if (!$margin_bottom) {
 //            $margin_bottom = 10;
 //        }
 //        if (!$margin_top) {
 //            $margin_top = 20;
 //        }
 //        $this->_ci->load->library('pdf');
 //        $pdf = new mPDF('utf-8', 'A4-' . $orientation, '13', '', 10, 10, $margin_top, $margin_bottom, 9, 9);
 //        $pdf->debug = false;
 //        $pdf->autoScriptToLang = true;
 //        $pdf->autoLangToFont = true;
        // $pdf->SetProtection(array('print')); // You pass 2nd arg for user password (open) and 3rd for owner password (edit)
 //        //$pdf->SetProtection(array('print', 'copy')); // Comment above line and uncomment this to allow copying of content
 //        $pdf->SetTitle($this->Settings->site_name);
 //        $pdf->SetAuthor($this->Settings->site_name);
 //        $pdf->SetCreator($this->Settings->site_name);
 //        $pdf->SetDisplayMode('fullpage');
 //        $stylesheet = file_get_contents('assets/bootstrap/css/bootstrap.min.css');
 //        $stylesheet = file_get_contents('assets/dist/css/AdminLTE.min.css');

 //        $pdf->WriteHTML($stylesheet, 1);
 //        // $pdf->SetFooter($this->Settings->site_name.'||{PAGENO}/{nbpg}', '', TRUE); // For simple text footer

 //        if (is_array($content)) {
 //            $pdf->SetHeader($this->Settings->site_name.'||{PAGENO}/{nbpg}', '', TRUE); // For simple text header
 //            $as = sizeof($content);
 //            $r = 1;
 //            foreach ($content as $page) {
 //                $pdf->WriteHTML($page['content']);
 //                if (!empty($page['footer'])) {
 //                    $pdf->SetHTMLFooter('<p class="text-center">' . $page['footer'] . '</p>', '', true);
 //                }
 //                if ($as != $r) {
 //                    $pdf->AddPage();
 //                }
 //                $r++;
 //            }

 //        } else {

 //            $pdf->WriteHTML($content);
 //            if ($header != '') {
 //                $pdf->SetHTMLHeader('<p class="text-center">' . $header . '</p>', '', true);
 //            }
 //            if ($footer != '') {
 //                $pdf->SetHTMLFooter('<p class="text-center">' . $footer . '</p>', '', true);
 //            }

 //        }

 //        if ($output_type == 'S') {
 //            $file_content = $pdf->Output('', 'S');
 //            write_file('assets/uploads/' . $name, $file_content);
 //            return 'assets/uploads/' . $name;
 //        } else {
 //            $pdf->Output($name, $output_type);
 //        }
 //    }

    // Send JSON to page
    // 
    public function send_json($data)
    {
        header('Content-Type: application/json');
        die(json_encode($data));
        exit;
    }


} 