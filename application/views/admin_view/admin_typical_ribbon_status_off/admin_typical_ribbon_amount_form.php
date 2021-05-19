<section class="section" style="min-height: 500px">
    <div class="columns">
        <div class="column is-one-fifth">
            <?= $sidemenu ?>
        </div>
        <div class="column is-four-fifths">
            <div class="container">
                <div id="profile" class="container form-detail">
                    <progress id="loading-page" class="progress is-small is-link" max="100">15%</progress>
                    <div class="is-size-4">รอบปกติ ชั้นสายสะพาย</div>
                    <div class="container content is-size-5">พิมพ์บัญชีสรุปจำนวน</div>
                    <div class="is-size-6">
                        สถานะ
                        <span class="has-text-danger" title="นขต.บก.ทท. ไม่สามารถแก้ไขได้">ปิดระบบแล้ว</span>
                    </div>
                    
                    <div class="container content">
                        <form id="property-form" method="post" action="<?= site_url('admin_typical_ribbon_status_off/action_get_ribbon_amount') ?>" target="_blank">
                            <div class="field is-horizontal">
                                <div class="field-label is-normal">
                                    <label class="label">ค้นหาหน่วย</label>
                                </div>
                                <div class="field-body">
                                    <div class="field">
                                        <div class="control">
                                            <div class="columns">
                                                <div class="column is-one-third">
                                                    <input type="text" id="search-unit" class="input" placeholder="ค้นหาชื่อหน่วย">
                                                </div>
                                            </div>
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
                                <div class="field-label is-normal">
                                    <label class="label">ปีที่ขอ</label>
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
                                    <label class="label">เงื่อนไข</label>
                                </div>

                                <div class="field-body">
                                    <div class="field">
                                        <div class="control">
                                            <div class="select">
                                                <select name="condition">
                                                    <option value="normal">ปกติ</option>
                                                    <option value="retire">เกษียณ</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <hr />

                            <div class="field is-horizontal">
                                <div class="field-label is-normal"></div>

                                <div class="field-body">
                                    <div class="field">
                                        <label class="label">ชื่อผู้ลงนาม</label>
                                    </div>
                                </div>
                            </div>

                            <div class="field is-horizontal">
                                <div class="field-label is-normal">
                                    <label class="label">ยศ</label>
                                </div>

                                <div class="field-body">
                                    <div class="field">
                                        <div class="control">
                                            <input class="input" type="text" name="p1_rank" placeholder="Text input">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="field is-horizontal">
                                <div class="field-label is-normal">
                                    <label class="label">ชื่อ - สกุล</label>
                                </div>

                                <div class="field-body">
                                    <div class="field">
                                        <div class="control">
                                            <input class="input" type="text" name="p1_name" placeholder="Text input">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="field is-horizontal">
                                <div class="field-label is-normal">
                                    <label class="label">ตำแหน่ง</label>
                                </div>

                                <div class="field-body">
                                    <div class="field">
                                        <div class="control">
                                            <input class="input" type="text" name="p1_position" placeholder="Text input">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="field is-horizontal">
                                <div class="field-label"></div>
                                <div class="field-body">
                                    <div class="field">
                                        <button class="button is-primary">Submit</button>
                                        <button id="search-reset" type="reset" class="button">Reset</button>
                                    </div>
                                </div>
                            </div>
                        </form>

                        <div id="property-form-result"></div>
                        <div id="property-form-data"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
    $(document).ready(function() {
        $("ul#typical-ribbon").removeClass('is-hidden');
        $("a#admin-typical-ribbon-amount-person").addClass('is-active');


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
    });
</script>