<?php namespace Libs;

class GroupsGridrecord extends \System\GridsRecord
{
	// https://www.iconfinder.com/iconsets/fatcow
	public function __construct($id)
	{
		parent::__construct($id);

		$this->view           = '~admin_panel.groups.index';
		$this->icon           =  NULL;
		$this->caption        = 'Clasa';
		$this->toolbar        = '~admin_panel.groups.toolbar';
		$this->name           = 'dt';
		$this->display_start  = 0;
		$this->display_length = 50;
		$this->default_order  = "1,'asc'";
		$this->form           = NULL;
		$this->css            = '';
		$this->js             = 'assets/js/dtable.js, assets/js/groups/clasa.js';
		$this->row_source     = 'index-groups-row-sources';
		$this->rows_source_sql 				= 
			"
			SELECT *,
			(select count(*)  nr from group_student where group_student.group_id = gr.id) as nr_elevi,
			(select CONCAT(teachers.firstname,\" \", teachers.lastname) from teachers 
				left join users on users.userable_id = teachers.id
			 where users.userable_type like '%teacher%' and users.id = gr.master_id) as profesor,
			(select teachers.image from teachers 
				left join users on users.userable_id = teachers.id
			 where users.userable_type like \"%teacher%\" and users.id = gr.master_id) as profesor_image
			from groups as gr

			:where:
			:order:
			";
		$this->count_filtered_records_sql 	= 
			"
			SELECT 
				COUNT(*) as cnt   
				from groups  
			:where:
			";
		$this->count_total_records_sql     	= 
			"
			SELECT 
				COUNT(*) as cnt   
				from groups
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
				'source'    => '~admin_panel.groups.nume',
			],
			'3' => [
				'id'        => 'nr_elevi',
				'orderable' => 'yes',
				'class'     => 'td-record-count td-align-left',
				'visible'   => 'yes',
				'header'    => ['caption' => 'Numărul de elevi', 'style'   => 'width:20%; text-align:center',],
				'type'      => 'field',
				'source'    => 'nr_elevi',
			],
			'4' => [
				'id'        => 'diriginte',
				'orderable' => 'yes',
				'class'     => 'td-record-count td-align-left',
				'visible'   => 'yes',
				'header'    => ['caption' => 'Diriginte', 'style'   => 'width:20%; text-align:center',],
				'type'      => 'view',
				'source'    => '~admin_panel.groups.diriginte',
			], 
			'5' => [
				'id'        => 'actions_suplimentare',
				'orderable' => 'yes',
				'class'     => 'td-record-count td-align-left actions',
				'visible'   => 'yes',
				'header'    => ['caption' => 'Acțiuni suplimentare', 'style'   => 'width:20%; text-align:center',],
				'type'      => 'view',
				'source'    => '~admin_panel.groups.actions_suplimentare',
			], 
			'6' => [
				'id'        => 'actions',
				'orderable' => 'yes',
				'class'     => 'td-record-count td-align-left actions',
				'visible'   => 'yes',
				'header'    => ['caption' => 'Acțiuni', 'style'   => 'width:20%; text-align:center',],
				'type'      => 'view',
				'source'    => '~admin_panel.groups.actions',
			], 
			
		];
		$this->fields = [
			'fields'      => '',
			'searchables' => 'diriginte',
			'orderables'  => [1 => '1'],
		];
		$this->filters = [];

	}

    public static function create()
	{
		return self::$instance = new GroupsGridrecord('groups-index');
	}
	
}