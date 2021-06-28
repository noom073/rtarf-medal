<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Admin_spreadsheet_model extends CI_Model
{

    private $oracle;

    function __construct()
    {
        parent::__construct();
        $this->oracle = $this->load->database('oracle', true);
    }

    public function xlsData()
    {
        $sql = "select 'บก.ทท.'as UNIT,biog_unitname,biog_id,biog_idp,biog_name,decode(BIOG_CDEP,'1','ทบ.','2','ทร.','3','ทอ.') as CDEP,
        substr(BIOG_NAME,1,instr(BIOG_NAME,' ') - 1) as RANK ,
        substr(BIOG_NAME,instr(BIOG_NAME,' ') + 1,(instr(BIOG_NAME,'  ')) - (instr(BIOG_NAME,' '))) as FNAME,
        (replace(substr(BIOG_NAME,instr(BIOG_NAME,'  ') + 2 ,length(BIOG_NAME)),'ร.น.')) as LNAME,
        decode(BIOG_SEX,'0','ชาย','1','หญิง') as sex,biog_dmy_born,biog_salary,biog_dec,RETURN_POSNAME_CDEC(biog_id,biog_decy) as POSNAME_PRV,
        biog_decy,BIOG_POSNAME_full,
        ---RETURN_POSNAME_CDEC(cdec_id,substr(cdec_dmyget,5,4)||'10'),
        --biog_slevel,biog_sclass,biog_salary,
        /*replace(NAME,'ร.น.','') as NAME,biog_id,*/PER_BDEC_TAB.BDEC_COIN as   BDEC_COIN_NXT--,retire60(biog_dmy_born) as RET_YEAR,
        /*case 
        when retire60(biog_dmy_born) = '2564' then 'RET'
        else ''
        end as TYPE*/
        from 
        (
        select biog_unitname,biog_idp,biog_name,BIOG_POSNAME_full,biog_dec,biog_decy,BIOG_RANK,BIOG_SEX,BIOG_CDEP,cut_name(biog_name) as NAME,biog_id,biog_dmy_born,biog_slevel,biog_sclass,biog_salary
               from per_biog_back_dec_tab
               where  biog_rank between '01' AND '99'
               and biog_id in(select bdec_id from per_bdec_tab
                     where BDEC_ROUND = 'P0'
                        and bdec_coin in('ม.ป.ช.','ม.ว.ม.','ป.ช.','ป.ม.'))
        union
        select biog_unitname,biog_idp,biog_name,BIOG_POSNAME_full,biog_dec,biog_decy,BIOG_RANK,BIOG_SEX,BIOG_CDEP,cut_name(biog_name) as NAME,biog_id,biog_dmy_born,biog_slevel,biog_sclass,biog_salary
               from per_biog_back_dec_tab
               where  biog_rank between '05' AND '99'
               and biog_id in(select bdec_id from per_bdec_tab
                     where BDEC_ROUND = 'P0'
                        and bdec_coin in('ท.ช.'))
        --order by BIOG_RANK,BIOG_SEX,BIOG_CDEP,cut_name(biog_name)
         union
        select biog_unitname,biog_idp,biog_name,BIOG_POSNAME_full,biog_dec,biog_decy,BIOG_RANK,BIOG_SEX,BIOG_CDEP,cut_name(biog_name),biog_id,biog_dmy_born,biog_slevel,biog_sclass,biog_salary
                 from per_biog_back_dec_tab
            where  biog_rank between '05' AND '99'
        and biog_id in(select bdec_id from per_bdec_tab
                     where BDEC_ROUND = 'P0'
                        and bdec_coin in('ท.ม.'))
        --order by BIOG_RANK,BIOG_SEX,BIOG_CDEP,cut_name(biog_name)
        union
        select biog_unitname,biog_idp,biog_name,BIOG_POSNAME_full,biog_dec,biog_decy,BIOG_RANK,BIOG_SEX,BIOG_CDEP,cut_name(biog_name),biog_id,biog_dmy_born,biog_slevel,biog_sclass,biog_salary
                 from per_biog_back_dec_tab
            where  biog_rank between '05' AND '99'
        and biog_id in(select bdec_id from per_bdec_tab
                     where BDEC_ROUND = 'P0'
                        and bdec_coin in('ต.ช.'))
        --order by BIOG_RANK,BIOG_SEX,BIOG_CDEP,cut_name(biog_name)
        union
        select biog_unitname,biog_idp,biog_name,BIOG_POSNAME_full,biog_dec,biog_decy,BIOG_RANK,BIOG_SEX,BIOG_CDEP,cut_name(biog_name),biog_id,biog_dmy_born,biog_slevel,biog_sclass,biog_salary
                 from per_biog_back_dec_tab
            where  biog_rank between '05' AND '99'
        and biog_id in(select bdec_id from per_bdec_tab
                     where BDEC_ROUND = 'P0'
                        and bdec_coin in('ต.ม.'))
        --order by BIOG_RANK,BIOG_SEX,BIOG_CDEP,cut_name(biog_name)
        union
        select biog_unitname,biog_idp,biog_name,BIOG_POSNAME_full,biog_dec,biog_decy,BIOG_RANK,BIOG_SEX,BIOG_CDEP,cut_name(biog_name),biog_id,biog_dmy_born,biog_slevel,biog_sclass,biog_salary
                 from per_biog_back_dec_tab
            where  biog_rank between '05' AND '99'
        and biog_id in(select bdec_id from per_bdec_tab
                     where BDEC_ROUND = 'P0'
                        and bdec_coin in('จ.ช.'))
        --order by BIOG_RANK,BIOG_SEX,BIOG_CDEP,cut_name(biog_name)
        union
        select biog_unitname,biog_idp,biog_name,BIOG_POSNAME_full,biog_dec,biog_decy,BIOG_RANK,BIOG_SEX,BIOG_CDEP,cut_name(biog_name),biog_id,biog_dmy_born,biog_slevel,biog_sclass,biog_salary
                 from per_biog_back_dec_tab
            where  biog_rank between '05' AND '99'
        and biog_id in(select bdec_id from per_bdec_tab
                     where BDEC_ROUND = 'P0'
                        and bdec_coin in('จ.ม.'))
        --order by BIOG_RANK,BIOG_SEX,BIOG_CDEP,cut_name(biog_name)
        union
        select biog_unitname,biog_idp,biog_name,BIOG_POSNAME_full,biog_dec,biog_decy,BIOG_RANK,BIOG_SEX,BIOG_CDEP,cut_name(biog_name),biog_id,biog_dmy_born,biog_slevel,biog_sclass,biog_salary
                 from per_biog_back_dec_tab
            where  biog_rank between '05' AND '99'
        and biog_id in(select bdec_id from per_bdec_tab
                     where BDEC_ROUND = 'P0'
                        and bdec_coin in('บ.ช.'))
        --order by BIOG_RANK,BIOG_SEX,BIOG_CDEP,cut_name(biog_name)
        union
        select biog_unitname,biog_idp,biog_name,BIOG_POSNAME_full,biog_dec,biog_decy,BIOG_RANK,BIOG_SEX,BIOG_CDEP,cut_name(biog_name),biog_id,biog_dmy_born,biog_slevel,biog_sclass,biog_salary
                 from per_biog_back_dec_tab
            where  biog_rank between '05' AND '99'
        and biog_id in(select bdec_id from per_bdec_tab
                     where BDEC_ROUND = 'P0'
                        and bdec_coin in('บ.ม.'))
        --order by BIOG_RANK,BIOG_SEX,BIOG_CDEP,cut_name(biog_name)
        union
        select biog_unitname,biog_idp,biog_name,BIOG_POSNAME_full,biog_dec,biog_decy,BIOG_RANK,BIOG_SEX,BIOG_CDEP,cut_name(biog_name),biog_id,biog_dmy_born,biog_slevel,biog_sclass,biog_salary
                 from per_biog_back_dec_tab
            where  biog_rank between '05' AND '99'
        and biog_id in(select bdec_id from per_bdec_tab
                     where BDEC_ROUND = 'P0'
                        and bdec_coin in('ร.ท.ช.'))             
        ) DEC,per_bdec_tab --,PER_CDEC_TAB
        where  DEC.biog_id = PER_BDEC_TAB.BDEC_ID      
        order by PER_BDEC_TAB.BDEC_CSEQ ,BIOG_SEX,cut_name(biog_name)";
        $query = $this->oracle->query($sql);
        return $query;
    }
}
