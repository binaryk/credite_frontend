<?php namespace Libs;

class ProfesorClaselemeleGridrecord extends \System\GridsRecord
{
	// https://www.iconfinder.com/iconsets/fatcow
	public function __construct($id)
	{
		parent::__construct($id);

		$this->view           = '~libs.profesor.clasele-mele.index';
		$this->icon           =  NULL;
		$this->caption        = 'Clasele mele';
		$this->toolbar        = '~libs.profesor.clasele-mele.toolbar';
		$this->name           = 'dt';
		$this->display_start  = 0;
		$this->display_length = 50;
		$this->default_order  = "1,'asc'";
		$this->form           = NULL;
		$this->css            = '';
		$this->js             = '';
		$this->row_source     = 'index-profesor-clasele-mele-row-sources';
		$this->header_filter  = true;
		$this->rows_source_sql 				= 
			"
			SELECT
				CONCAT(groups.num, groups.letter) as group_sorterable,
				subject_teacher_group.*,
				groups.name as nume_clasa, groups.letter,
				numar_elevi.numar_elevi,
				users.name as nume_diriginte,
				teachers.phone,
				teachers.image,
				subjects.name as nume_materie
			FROM subject_teacher_group
			LEFT JOIN groups 
				LEFT JOIN users
					LEFT JOIN teachers
					ON users.userable_id = teachers.id
				ON groups.master_id = users.id
			ON subject_teacher_group.group_id = groups.id
			LEFT JOIN 
				(
					SELECT
						group_id,
						COUNT(*) as numar_elevi
					FROM group_student
					GROUP BY group_id
					ORDER BY group_id
				) AS numar_elevi
		    ON subject_teacher_group.group_id = numar_elevi.group_id
		    LEFT JOIN subjects ON subject_teacher_group.subject_id = subjects.id
			:where:
			:order:
			";
		$this->count_filtered_records_sql 	= 
			"
			SELECT 
				COUNT(*) as cnt 
			FROM subject_teacher_group 
			LEFT JOIN groups 
			ON subject_teacher_group.group_id = groups.id
			:where:
			";
		$this->count_total_records_sql     	= 
			"
			SELECT 
				COUNT(*) as cnt 
			FROM subject_teacher_group 
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
				'id'        => 'clasa',
				'orderable' => 'yes',
				'class'     => 'td-align-left',
				'visible'   => 'yes',
				'header'    => ['caption' => 'Clasă', 'style'   => 'width:10%; text-align:center', 'filter' => true],
				'type'      => 'view',
				'source'    => '~libs.profesor.clasele-mele.clasa',
			],
			'3' => [
				'id'        => 'numar-copii',
				'orderable' => 'no',
				'class'     => 'td-align-center',
				'visible'   => 'yes',
				'header'    => ['caption' => 'Număr de elevi', 'style'   => 'width:10%; text-align:center',],
				'type'      => 'view',
				'source'    => '~libs.profesor.clasele-mele.numar-elevi',
			],

			'4' => [
				'id'        => 'diriginte',
				'orderable' => 'no',
				'class'     => 'td-align-left',
				'visible'   => 'yes',
				'header'    => ['caption' => 'Diriginte', 'style'   => 'width:25%; text-align:center', 'filter' => true],
				'type'      => 'view',
				'source'    => '~libs.profesor.clasele-mele.diriginte',
			],

			'5' => [
				'id'        => 'telefon',
				'orderable' => 'no',
				'class'     => 'td-align-left',
				'visible'   => 'yes',
				'header'    => ['caption' => 'Număr de telefon', 'style'   => 'width:15%; text-align:center', 'filter' => true],
				'type'      => 'view',
				'source'    => '~libs.profesor.clasele-mele.telefon',
			],
			'6' => [
				'id'        => 'materie',
				'orderable' => 'no',
				'class'     => 'td-align-left',
				'visible'   => 'yes',
				'header'    => ['caption' => 'Disciplina', 'style'   => 'width:20%; text-align:center',],
				'type'      => 'view',
				'source'    => '~libs.profesor.clasele-mele.materie',
			],
			'7' => [
				'id'        => 'actiuni',
				'orderable' => 'no',
				'class'     => 'td-align-left',
				'visible'   => 'yes',
				'header'    => ['caption' => 'Acces clasă', 'style'   => 'width:15%; text-align:center',],
				'type'      => 'view',
				'source'    => '~libs.profesor.clasele-mele.actiuni',
			],
		];
		$this->fields = [
			'fields'      => '',
			'searchables' => '',
			'orderables'  => [1 => '1'],
		];
		$this->filters = [];

	}

    public static function create()
	{
		return self::$instance = new ProfesorClaselemeleGridrecord('profesor-clasele-mele');
	}
	
}