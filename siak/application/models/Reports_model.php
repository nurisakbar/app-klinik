<?php
Class Reports_model extends CI_Model {

	public function count_all($ledgerId = NULL, $startDate = NULL, $endDate = NULL) {
		if ($ledgerId === NULL) {
			return FALSE;
		}

		$conditions = array();
		$conditions['entryitems.ledger_id'] = $ledgerId;

		/* Opening and closing titles */
		if (!is_null($startDate) && !empty($startDate)) {
			$conditions['entries.date >='] = $startDate;
		}

		if (!is_null($endDate) || !empty($endDate)) {
			$conditions['entries.date <='] = $endDate;
		}
		$this->DB1->where($conditions)
		->join('entryitems', 'entries.id = entryitems.entry_id', 'left');

		$query = $this->DB1->get("entries");
		return $query->num_rows();
	}

	// public function fetch_details($limit, $start, $ledgerId = NULL, $startDate = NULL, $endDate = NULL) {
	// 	$data = $this->ledgerstatement('ajax');
	// 	extract($data);
		
	// 	echo "<pre>";
	// 	print_r($data);
	// 	echo "</pre>";
	// 	die();

	// 	$output = '';

	// 	$output .= '<table class="stripped" id="ledgerstatement_table" style="width: 100%;">
	// 		<thead>
	// 			<tr>
	// 				<th>' . lang('date') . '</th>
	// 				<th>' . lang('number') . '</th>
	// 				<th>' . lang('ledger') . '</th>
	// 				<th>' . lang('type') . '</th>
	// 				<th>' . lang('tag') . '</th>
	// 				<th>' . lang('dr_amount') . ' (' . $this->mAccountSettings->currency_symbol . ')</th>
	// 				<th>' . lang('cr_amount') . ' (' . $this->mAccountSettings->currency_symbol . ')</th>
	// 				<th>' . lang('balance') . '' . ' (' . $this->mAccountSettings->currency_symbol . ')</th>
	// 				<th>' . lang('actions') . '</th>
	// 			</tr>
	// 		</thead>
	// 		<tbody>';
	// 	foreach($data as $row) {
	// 		/* Negative balance if its a cash or bank account and balance is Cr */
	// 		// if ($row.ledger_data['type'] == 1) {
	// 		// 	if ($row.entry_balance['dc'] == 'C' && $row.entry_balance['amount'] != '0.00') {
	// 		// 		$output .= '<tr class="error-text">';
	// 		// 	} else {
	// 		// 		$output .= '<tr>';
	// 		// 	}
	// 		// } else {
	// 		// 	$output .= '<tr>';
	// 		// }

	// 		$output .= '<td>' + $row.date + '</td>';
	// 		$output .= '<td>' + $row.number + '</td>';
	// 		$output .= '<td>' + $row.entry_id + '</td>';
	// 		$output .= '<td>' + $row.entryTypeName + '</td>';
	// 		$output .= '<td>' + $row.tag_id + '</td>';
	// 		$output .= '<td>' + $row.dr_total + '</td>';
	// 		$output .= '<td>' + $row.cr_total + '</td>';
	// 		$output .= '<td>' + $row.balance + '</td>';
	
	// 	 	$output .= '<td><a href="<?= base_url("entries/view/") . ''+($row.entryTypeLabel)+'/'+$row.id+'" style="padding-right: 5px;" title="<?= lang('view') . '" data-toggle="tooltip"><i class="glyphicon glyphicon-log-in"></i></a>';

	// 	 	$output .= '<a href="<?= base_url("entries/edit/") . ''+($row.entryTypeLabel)+'/'+$row.id+'" style="padding-right: 1px;" title="<?= lang('edit') . '" data-toggle="tooltip"><i class="glyphicon glyphicon-edit"></i></a>';

	// 	 	$output .= '<a href="<?= base_url("entries/delete/") . ''+($row.entryTypeLabel)+'/'+$row.id+'" title="<?= lang('delete') . '" data-toggle="tooltip"><i class="glyphicon glyphicon-trash"></i></a></td>';

	// 		$output .= '</tr>';
	// 	}
	// 	$output .= '</tbody></table>';
	// 	return $output;
	// }

	/**
	* Show the entry ledger details
	*/
	public function buildTree(array $elements, $parentId = 0) {
	    $branch = array();
	    foreach ($elements as $element) {
	        if ($element->parent_id == $parentId) {
	            $children = $this->buildTree($elements, $element->id);
	            if ($children) {
	            	$branch = array_merge($branch, $children);
	            }
	            $branch[] = $element->id;
	        }
	    }
	    return $branch;
	}

	public function getTotalPeriodical($id) {
   		// build our category list only once
	   	$cats = [];
		$q = $this->DB1->get('groups');
		if ($q->num_rows() > 0) {
			$cats = $q->result();
		}

		$parent_ids = $this->buildTree($cats, $id);

		$q = $this->DB1
			->select('SUM(amount) as total, date')
			->join('ledgers', 'entryitems.ledger_id=ledgers.id', 'left')
			->join('entries', 'entries.id=entryitems.entry_id', 'left')
			->where_in('ledgers.group_id', $parent_ids)
			->group_by('entries.id')
			->where("MONTH(".$this->DB1->dbprefix('entries').".date) = MONTH(CURRENT_DATE()) AND YEAR(".$this->DB1->dbprefix('entries').".date) = YEAR(CURRENT_DATE())", NULL, FALSE)
			->from('entryitems')
			->get();
			
			$number = array();
	        for ($i = 1; $i <= 31; $i++) {
	            $number[$i] = 0;
	        }

			if ($q->num_rows() > 0) {
				$data = $q->result_array();
				$dated = array();
				foreach ($data as $row) {
					if(array_key_exists($row['date'], $dated)){
				        $dated[$row['date']]['total']	+= $row['total'];
				        $dated[$row['date']]['date']	= $row['date'];
				    } else {
				        $dated[$row['date']]  = $row;
				    }
				}
				foreach ($dated as $row) {
					$id = @date('j', strtotime($row['date']));
		            $number[$id] = $number[$id] + @$row['total'];
				}
			}

			
			return array_values($number);
	}

	
	public function getTotalofToday($id) {
   		// build our category list only once
	   	$cats = [];
		$q = $this->DB1->get('groups');
		if ($q->num_rows() > 0) {
			$cats = $q->result();
		}

		$parent_ids = $this->buildTree($cats, $id);

		$q = $this->DB1
			->select('SUM(amount) as total, date')
			->join('ledgers', 'entryitems.ledger_id=ledgers.id', 'left')
			->join('entries', 'entries.id=entryitems.entry_id', 'left')
			->where_in('ledgers.group_id', $parent_ids)
			->group_by($this->DB1->dbprefix('entries').".date")
			->where($this->DB1->dbprefix('entries').".date = CURRENT_DATE()", NULL, FALSE)
			->from('entryitems')
			->get();
			
		if ($q->num_rows() > 0) {
			$data = $q->row();
			return $data->total;
		}
		return false;
	}

	public function getTotalofThisMonth($id) {
   		// build our category list only once
	   	$cats = [];
		$q = $this->DB1->get('groups');
		if ($q->num_rows() > 0) {
			$cats = $q->result();
		}

		$parent_ids = $this->buildTree($cats, $id);

		$q = $this->DB1
			->select('SUM(amount) as total, date')
			->join('ledgers', 'entryitems.ledger_id=ledgers.id', 'left')
			->join('entries', 'entries.id=entryitems.entry_id', 'left')
			->where_in('ledgers.group_id', $parent_ids)
			->group_by("MONTH(".$this->DB1->dbprefix('entries').".date)")
			->where("MONTH(".$this->DB1->dbprefix('entries').".date) = MONTH(CURRENT_DATE()) AND YEAR(".$this->DB1->dbprefix('entries').".date) = YEAR(CURRENT_DATE())", NULL, FALSE)
			// ->where($this->DB1->dbprefix('entries').".date = CURRENT_DATE()", NULL, FALSE)
			->from('entryitems')
			->get();
			
		if ($q->num_rows() > 0) {
			$data = $q->row();
			return $data->total;
		}
		return false;
	}

	public function getTotalMonthly($id) {
		$number = array();
		for ($i=7; $i >= 0 ; $i--) {
			$date = new DateTime('now');
			$date->modify('first day of -'.$i.' month');

			$number[$date->format('Y-m')] = 0;
		}

		if ($id == 0) {
			$xAxis = array_keys($number);
			foreach ($xAxis as $key => $offset) {
				$new_offset = date('M Y', strtotime($offset));
				$xAxis[$key] = $new_offset;
			}
			return $xAxis;
		}

   		// build our category list only once
	   	$cats = [];
		$q = $this->DB1->get('groups');
		if ($q->num_rows() > 0) {
			$cats = $q->result();
		}

		$parent_ids = $this->buildTree($cats, $id);			

		$q = $this->DB1
			->select('SUM(amount) as total, date, MONTH(date) as month, YEAR(date) as year, DATE_FORMAT(`date`,"%Y-%m") as offset')
			->join('ledgers', 'entryitems.ledger_id=ledgers.id', 'left')
			->join('entries', 'entries.id=entryitems.entry_id', 'left')
			->where_in('ledgers.group_id', $parent_ids)
			->group_by("offset")
			->where($this->DB1->dbprefix('entries').".date <= NOW() and ".$this->DB1->dbprefix('entries').".date >= Date_add(Now(),interval - 12 month)")
			->from('entryitems')
			->get();

		if ($q->num_rows() > 0) {
			$data = $q->result_array();
			$dated = array();
			foreach ($data as $row) {
				if(array_key_exists($row['offset'], $dated)){
			        $dated[$row['offset']]['total']	.= $row['total'];
			        $dated[$row['offset']]['date']	= $row['date'];
			    } else {
			        $dated[date('Y-m', strtotime($row['date']))]  = $row;
			    }
			}	

			foreach ($dated as $row) {
				$id = $row['offset'];
				if (array_key_exists($id, $number)) {
					$number[$id] = @$row['total'];
				}
			}

			return array_values($number);
		}
		return FALSE;
	}

	// public function getTotalPeriodical($id) {
	// 	$q = $this->DB1
	// 		->select('(if(op_balance_dc = "C", cr_total, dr_total)) as total, date')
	// 		->join('ledgers', 'entryitems.ledger_id=ledgers.id', 'left')
	// 		->join('groups', 'ledgers.group_id=groups.id', 'left')
	// 		->join('entries', 'entries.id=entryitems.entry_id', 'left')
	// 		->where('GetAncestry('.$this->DB1->dbprefix('groups').'.id, \''.$this->DB1->dbprefix('groups').'\') = ', $id)
	// 		->group_by('entries.id')
	// 		->where("MONTH(".$this->DB1->dbprefix('entries').".date) = MONTH(CURRENT_DATE()) AND YEAR(".$this->DB1->dbprefix('entries').".date) = YEAR(CURRENT_DATE())", NULL, FALSE)
	// 		->from('entryitems')
	// 		->get();
			
	// 		$number = array();
	//         for ($i = 1; $i <= 31; ++$i) {
	//             $number[$i] = 0;
	//         }

	// 		if ($q->num_rows() > 0) {
	// 			$data = $q->result_array();
	// 			$dated = array();
	// 			foreach ($data as $row) {
	// 				if(array_key_exists($row['date'], $dated)){
	// 			        $dated[$row['date']]['total']	.= $row['total'];
	// 			        $dated[$row['date']]['date']	= $row['date'];
	// 			    } else {
	// 			        $dated[$row['date']]  = $row;
	// 			    }
	// 			}
	// 			foreach ($dated as $row) {
	// 				$id = @date('j', strtotime($row['date']));
	// 	            $number[$id] = $number[$id] + @$row['total'];
	// 			}
	// 		}

			
	// 		return array_values($number);
	// }

}