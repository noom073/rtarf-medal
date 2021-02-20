<section class="section" style="min-height: 500px">
    <div class="columns">
        <div class="column is-one-fifth">
            <?= $sidemenu ?>
        </div>
        <div class="column is-four-fifths">
            <div class="container">
                <progress id="loading-page" class="progress is-small is-link" max="100">15%</progress>
                <h1 class="container content is-size-4">บัญชีการรับเครื่องราชฯ ชั้นสายสะพาย</h1>
                <div class="container">
                    <div class="content">
                        <div class="is-size-5 content">เครื่องราชฯ ชั้นสายสะพาย</div>
                        <div class="columns">
                            <div class="column is-half">
                                <form id="ribbon-report-form" method="post" action="<?= site_url('admin_fundamental/ajax_ribbon_generate_report') ?>">
                                    <div class="field is-horizontal">
                                        <div class="field-label is-normal">
                                            <label class="label">เลือกปีที่ขอ</label>
                                        </div>
                                        <div class="field-body">
                                            <div class="field">
                                                <div class="control">
                                                    <div class="select">
                                                        <select name="year">
                                                            <?php for ($i = 0; $i < 6; $i++) { ?>
                                                                <option value="<?= (date("Y") + 543) + $i ?>"><?= (date("Y") + 543) + $i ?></option>
                                                            <?php } ?>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="field is-horizontal">
                                        <div class="field-label is-normal">
                                            <label class="label">ค้นหาหน่วย</label>
                                        </div>
                                        <div class="field-body">
                                            <div class="field">
                                                <div class="control">
                                                    <input type="text" id="search-unit" class="input" placeholder="ค้นหาชื่อหน่วย">
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="field is-horizontal">
                                        <div class="field-label is-normal">
                                            <label class="label">หน่วย</label>
                                        </div>

                                        <div class="field-body">
                                            <div class="field">
                                                <div class="select">
                                                    <select id="unitid" name="unitid"></select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="field is-horizontal">
                                        <div class="field-label"></div>
                                        <div class="field-body">
                                            <button id="ribbon-report-form-submit" class="button is-primary">
                                                Submit
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
    $(document).ready(function() {
        $("ul#fdmt-report-ul").removeClass('is-hidden');
        $("a#fdmt-report-ul-ribbon").addClass('is-active');


        const getUnit = () => {
            return $.get({
                url: '<?= site_url("admin/ajax_get_unit") ?>',
                dataType: 'json'
            }).done(res => {}).fail((jhr, status, error) => console.error(jhr, status, error));
        };


        let units = new Array();
        const setUnitSelect = async () => {
            units = await getUnit();
            $("#loading-page").addClass('is-invisible');
            let option = '';
            units.forEach(r => {
                option += `<option value="${r.NPRT_UNIT}">${r.NPRT_ACM}</option>`;
            });
            $("#unitid").html(option);
        };
        setUnitSelect();


        $("#search-unit").blur(async function() {
            let searchText = $(this).val();
            let result = units.filter(r => r.NPRT_ACM.includes(searchText));
            let option = '';
            result.forEach(r => {
                option += `<option value="${r.NPRT_UNIT}">${r.NPRT_ACM}</option>`;
            });
            $("#unitid").html(option);
        });


        $("#ribbon-report-form").submit(function() {
            $("#ribbon-report-form-submit").addClass("is-loading");
        });


    });
</script>