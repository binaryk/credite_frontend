<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTablePersoaneFiziceFromServer extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('persoane_fizice', function(Blueprint $t)
        {
            $t->increments('id');
            $t->integer('id_organizatie');
            $t->integer('tip_client');
            //Sectiunea 1: Date de identificare
            $t->text('nume',50);
            $t->text('prenume',50);
            $t->text('cnp',50);
            $t->text('email',50);
            $t->text('telefon',50);
            $t->text('nume_mama',50);
            //Sectiunea 2: Venituri
            $t->double('salariu_net');
            $t->tinyinteger('salariu');
            $t->tinyinteger('diurne');
            $t->tinyinteger('pensie');
            $t->tinyinteger('dividende');
            $t->tinyinteger('indemniz_copil');
            $t->tinyinteger('activitati_indep');
            $t->tinyinteger('profesii_liberale');
            $t->tinyinteger('drepturi_de_autor');
            $t->tinyinteger('chirii');
            $t->tinyinteger('rente_viagere');
            $t->tinyinteger('comisioane');
            $t->tinyinteger('ore_suplimentare');
            $t->tinyinteger('contracte_de_management');
            $t->tinyinteger('contracte_de_mandat');
            $t->tinyinteger('norma_de_hrana');
            $t->text('bonuri_de_masa',50);
            $t->tinyinteger('no_bonuri_de_masa');
            $t->text('per_contract', 20);
            $t->double('alte_venituri',50);
            $t->text('per_alte_ven', 20);
            $t->tinyinteger('alt_ven_salar');
            $t->tinyinteger('alt_ven_diurne');
            $t->tinyinteger('alt_ven_pensie');
            $t->tinyinteger('alt_ven_divid');
            $t->tinyinteger('alt_ven_indemn_copil');
            $t->tinyinteger('alt_ven_activ_indep');
            $t->tinyinteger('alt_ven_prfs_lbrl');
            $t->tinyinteger('alt_ven_drept_de_autor');
            $t->tinyinteger('alt_ven_chirii');
            $t->tinyinteger('alt_ven_rente_viagere');
            $t->tinyinteger('alt_ven_cmsne');
            $t->tinyinteger('alt_ven_ore_suplim');
            $t->tinyinteger('alt_ven_cntrct_de_mngmnt');
            $t->tinyinteger('alt_ven_cntrct_de_mandat');
            $t->tinyinteger('alt_ven_nrm_de_hrana');
            $t->double('tot_ven_net',50);
            //Sectiune 3: Date angajator
            $t->text('denum_angajator',50);
            $t->text('tip_angajator',50);
            $t->text('cui',50);
            $t->text('nr_angajati',20);
            $t->text('dom_de_actvte',50);
            //Sectiunea 4: Chestionar
            $t->text('ultim_stud_abs',20);
            $t->text('st_civila',20);
            $t->text('functie',50);
            $t->text('profesie',50);
            $t->text('nr_membri_fam',50);
            $t->text('pers_intrtnr',50);
            $t->tinyinteger('propr_auto');
            $t->text('sit_locativa',50);
            $t->text('vec_adr_curenta',50);
            $t->text('vec_loc_munca',50);
            $t->text('vec_tot_munca',50);
            $t->text('bnc_virare_salar',50);
            $t->tinyinteger('istoric_credit');
            $t->integer('istoric_tip_credit');
            $t->integer('istoric_tip_codebitor');
            $t->integer('istoric_descoperit_de_cont');
            $t->integer('istoric_card_credit');
            $t->integer('istoric_tip_credit_insitutie');
            $t->integer('istoric_tip_codebitor_insitutie');
            $t->integer('istoric_descoperit_de_cont_insitutie');
            $t->integer('istoric_card_credit_insitutie');
            $t->date('istoric_tip_credit_data_acordarii');
            $t->date('istoric_tip_codebitor_data_acordarii');
            $t->date('istoric_descoperit_de_cont_data_acordarii');
            $t->date('istoric_card_credit_data_acordarii');
            $t->float('istoric_tip_credit_rata_lunara');
            $t->float('istoric_tip_codebitor_rata_lunara');
            $t->float('istoric_descoperit_de_cont_rata_lunara');
            $t->float('istoric_card_credit_rata_lunara');
            $t->float('istoric_tip_credit_sold');
            $t->float('istoric_tip_codebitor_sold');
            $t->float('istoric_descoperit_de_cont_sold');
            $t->float('istoric_card_credit_sold');
            $t->tinyInteger('co_platitor');
            $t->date('data_scadentei');
            $t->float('rata_lunara');
            $t->float('euribor_procent');
            $t->tinyInteger('has_data_scadentei');
            $t->timestamps();
            $t->softDeletes();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('persoane_fizice');
    }
}
