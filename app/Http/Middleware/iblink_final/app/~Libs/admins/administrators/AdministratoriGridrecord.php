<?php namespace Libs;

class AdministratoriGridrecord extends \System\GridsRecord
{
	// https://www.iconfinder.com/iconsets/fatcow
	public function __construct($id)
	{
		parent::__construct($id);

		$this->view           = 'admins.index';
		$this->icon           =  NULL;
		$this->caption        = 'Clasa';
		$this->toolbar        = 'admins.toolbar';
		$this->name           = 'dt';
		$this->display_start  = 0;
		$this->display_length = 50;
		$this->default_order  = "1,'asc'";
		$this->form           = NULL;
		$this->css            = '';
		$this->js             = 'assets/js/dtable.js';
		$this->row_source     = 'index-admins-row-sources';
		$this->rows_source_sql 				= 
			"
			SELECT
				administrators.*, 
				users.email 
				from administrators 
				left join users 
				ON administrators.id = users.userable_id 
				WHERE
				users.userable_type LIKE \"%admin%\"
			:where:
			:order:
			";
		$this->count_filtered_records_sql 	= 
			"
			SELECT 
				COUNT(*) as cnt   
				from administrators 
				left join users 
				ON administrators.id = users.userable_id 
				WHERE
				users.userable_type LIKE \"%admin%\"
			:where:
			";
		$this->count_total_records_sql     	= 
			"
			SELECT 
				COUNT(*) as cnt   
				from administrators 
				left join users 
				ON administrators.id = users.userable_id 
				WHERE
				users.userable_type LIKE '%admin%'
			";
		$this->columns        = [
			'1' => [
				'id'        => '#',
				'orderable' => 'no',
				'class'     => 'td-record-count td-align-center',
				'visible'   => 'yes',
				'header'    => ['caption' => '#', 'style'   => 'width:5%; text-align:center',],
				'type'      => 'row-number',
				'source'    => 'row-number',
			],
			'2' => [
				'id'        => 'name',
				'orderable' => 'yes',
				'class'     => 'td-record-count td-align-left',
				'visible'   => 'yes',
				'header'    => ['caption' => 'Nume', 'style'   => 'width:20%; text-align:center',],
				'type'      => 'view',
				'source'    => 'admins.nume',
			],
			'3' => [
				'id'        => 'email',
				'orderable' => 'yes',
				'class'     => 'td-record-count td-align-left',
				'visible'   => 'yes',
				'header'    => ['caption' => 'Email', 'style'   => 'width:20%; text-align:center',],
				'type'      => 'field',
				'source'    => 'email',
			],
			'4' => [
				'id'        => 'phone',
				'orderable' => 'yes',
				'class'     => 'td-record-count td-align-left',
				'visible'   => 'yes',
				'header'    => ['caption' => 'Telefon', 'style'   => 'width:20%; text-align:center',],
				'type'      => 'field',
				'source'    => 'phone',
			],
			'5' => [
				'id'        => 'cnp',
				'orderable' => 'yes',
				'class'     => 'td-record-count td-align-left',
				'visible'   => 'yes',
				'header'    => ['caption' => 'CNP', 'style'   => 'width:20%; text-align:center',],
				'type'      => 'field',
				'source'    => 'cnp',
			],
			'6' => [
				'id'        => 'actions',
				'orderable' => 'yes',
				'class'     => 'td-record-count td-align-left actions',
				'visible'   => 'yes',
				'header'    => ['caption' => 'Acțiuni', 'style'   => 'width:20%; text-align:center',],
				'type'      => 'view',
				'source'    => 'admins.actions',
			], 
			
		];
		$this->fields = [
			'fields'      => '',
			'searchables' => 'students.firstname, students.lastname',
			'orderables'  => [1 => '1'],
		];
		$this->filters = [];

	}

    public static function create()
	{
		return self::$instance = new AdministratoriGridrecord('admins-index');
	}
	
}