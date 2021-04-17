<section class="section" style="min-height: 500px">
    <div class="columns">
        <div class="column is-one-fifth">
            <?= $sidemenu ?>
        </div>
        <div class="column is-four-fifths">
            <div class="container">
                <div id="profile" class="container form-detail">
                    <div class="container content is-size-4">
                        พิมพ์บัญชีแสดงคุณสมบัติ
                    </div>

                    <div class="container content">
                        <form id="property-form" method="post" action="<?= site_url('user_non_ribbon/action_get_person_prop') ?>">
                            <div class="field is-horizontal">
                                <div class="field-label is-normal">
                                    <label class="label">หน่วย</label>
                                </div>

                                <div class="field-body">
                                    <div class="field">
                                        <div class="select">
                                            <select id="unitid" name="unitid">
                                                <option value="<?= $unitID ?>"><?= $unitname ?></option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="field is-horizontal">
                                <div class="field-label is-normal">
                                    <label class="label">ชั้น</label>
                                </div>

                                <div class="field-body">
                                    <div class="field">
                                        <div class="control">
                                            <div class="select">
                                                <select name="ribbon_type">
                                                    <option value="ท.ช.">ท.ช.</option>
                                                    <option value="ท.ม.">ท.ม.</option>
                                                    <option value="ต.ช.">ต.ช.</option>
                                                    <option value="ต.ม.">ต.ม.</option>
                                                    <option value="จ.ช.">จ.ช.</option>
                                                    <option value="จ.ม.">จ.ม.</option>
                                                    <option value="บ.ช.">บ.ช.</option>
                                                    <option value="บ.ม.">บ.ม.</option>
                                                    <option value="ร.ท.ช.">ร.ท.ช.</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="field is-horizontal">
                                <div class="field-label is-noraml">
                                    <label class="label">ประเภท</label>
                                </div>
                                <div class="field-body">
                                    <div class="field">
                                        <div class="control">
                                            <div class="select">
                                                <select name="type">
                                                    <option value="officer">นายทหาร</option>
                                                    <option value="employee">ลูกจ้างประจำ</option>
                                                </select>
                                            </div>
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
                                    <label class="label">ตำแหน่ง <br /> ผู้เสนอขอพระราชทาน</label>
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
                                <div class="field-label is-normal">
                                    <label class="label">ยศ</label>
                                </div>

                                <div class="field-body">
                                    <div class="field">
                                        <div class="control">
                                            <input class="input" type="text" name="p2_rank" placeholder="Text input">
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
                                            <input class="input" type="text" name="p2_name" placeholder="Text input">
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
                                            <input class="input" type="text" name="p2_position" placeholder="Text input">
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
        console.log('ok');

        const init_func = function() {
            // $("ul#fdmt-report-ul").removeClass('is-hidden');
            $("a#people-property-ul-nonribbon").addClass('is-active');
        };
        init_func();

        $("#property-form").submit(function(event) {
            // $("#property-form-data").html('Loading...');           
        });
    });
</script>