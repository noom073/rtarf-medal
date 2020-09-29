<section class="section" style="min-height: 500px">
    <div class="columns">
        <div class="column is-one-fifth">
            <?= $sidemenu ?>
        </div>
        <div class="column is-four-fifths">
            <div class="container">
                <div id="profile" class="container form-detail">
                    <progress id="loading-page" class="progress is-small is-link" max="100">15%</progress>

                    <div class="container content">
                        <div class="is-size-4">รอบปกติ ชั้นสายสะพาย</div>
                        <div class="is-size-5">ข้อมูลพื้นฐาน</div>
                    </div>

                    <div class="container content">
                        <form id="search-form">
                            <div class="field is-horizontal">
                                <div class="field-label is-normal">
                                    <label class="label">หน่วย</label>
                                </div>

                                <div class="field-body">
                                    <div class="field">
                                        <div class="select is-fullwidth">
                                            <select id="unitid" name="unitid"></select>
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

                        <div class="mt-5">
                            <div class="">
                                <span>ผลการค้นหา:</span>
                                <span id="search-result"></span>
                                <div id="data-result"></div>
                            </div>
                            <div class="mt-3">
                                <table id="bdec-data" class="table is-striped">
                                    <thead>
                                        <tr>
                                            <th class="has-text-centered">ลำดับ</th>
                                            <th class="has-text-centered">เลขประจำตัว</th>
                                            <th class="">ยศ-ชื่อ-นามสกุล</th>
                                            <th class="has-text-centered">เครื่องราชฯ</th>
                                            <th class="has-text-centered">#</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script type="text/javascript" src="<?= base_url('assets/datatable/datatables.min.js') ?>"></script>

<script>
    $(document).ready(function() {
        (function() {
            $("ul#typical-ribbon").removeClass('is-hidden');
            $("a#admin-typical-ribbon-fundation").addClass('is-active');
        })();

        $.get({
            url: '<?= site_url("admin/ajax_get_unit") ?>',
            dataType: 'json'
        }).done(res => {
            let hq = res.filter(r => r.NPRT_KEY.substring(0, 2) == '60');
            let joint = res.filter(r => r.NPRT_KEY.substring(0, 2) == '61');
            let operation = res.filter(r => r.NPRT_KEY.substring(0, 2) == '62');
            let special = res.filter(r => r.NPRT_KEY.substring(0, 2) == '63');
            let education = res.filter(r => r.NPRT_KEY.substring(0, 2) == '64');

            let hqOpt = '<optgroup label="ส่วนบังคับบัญชา">';
            hq.forEach(r => {
                hqOpt += `<option value="${r.NPRT_UNIT}">${r.NPRT_ACM}</option>`
            });
            hqOpt += `</optgroup>`;

            let jointOpt = '<optgroup label="ส่วนเสนาธิการร่วม">';
            joint.forEach(r => {
                jointOpt += `<option value="${r.NPRT_UNIT}">${r.NPRT_ACM}</option>`
            });
            jointOpt += `</optgroup>`;

            let operationOpt = '<optgroup label="ส่วนปฏิบัติการ">';
            operation.forEach(r => {
                operationOpt += `<option value="${r.NPRT_UNIT}">${r.NPRT_ACM}</option>`
            });
            operationOpt += `</optgroup>`;

            let specialOpt = '<optgroup label="ส่วนกิจการพิเศษ">';
            special.forEach(r => {
                specialOpt += `<option value="${r.NPRT_UNIT}">${r.NPRT_ACM}</option>`
            });
            specialOpt += `</optgroup>`;

            let educationOpt = '<optgroup label="ส่วนการศึกษา">';
            education.forEach(r => {
                educationOpt += `<option value="${r.NPRT_UNIT}">${r.NPRT_ACM}</option>`
            });
            educationOpt += `</optgroup>`;

            $("#unitid").html(hqOpt + jointOpt + operationOpt + specialOpt + educationOpt);
            $("#loading-page").addClass('is-invisible');
        }).fail((jhr, status, error) => {
            console.error(jhr, status, error);
        });

        function drawDataTable(dataObj) {

            let num = 1;
            let dt = dataObj.map(r => {
                r['NUMBER'] = num++;
                return r;
            });
            console.log(dt);
            $("#search-result").text('Success');

            $("#bdec-data").DataTable({
                destroy: true,
                data: dataObj,
                columns: [{
                        data: 'NUMBER',
                        className: 'has-text-centered'
                    },
                    {
                        data: 'BDEC_ID',
                        className: 'has-text-centered biog-id'
                    },
                    {
                        data: 'BDEC_NAME'
                    },
                    {
                        data: 'BDEC_COIN',
                        className: 'has-text-centered medal'
                    },
                    {
                        data: 'BDEC_ID',
                        className: 'has-text-centered',
                        render: (data, type, row, meta) => {
                            let select = `<select class="medal-name">
                                    <option value="ม.ป.ช." ${row.BDEC_COIN == 'ม.ป.ช.' ? 'selected':''}>ม.ป.ช.</option>
                                    <option value="ม.ว.ม." ${row.BDEC_COIN == 'ม.ว.ม.' ? 'selected':''}>ม.ว.ม.</option>
                                    <option value="ป.ช." ${row.BDEC_COIN == 'ป.ช.' ? 'selected':''}>ป.ช.</option>
                                    <option value="ป.ม." ${row.BDEC_COIN == 'ป.ม.' ? 'selected':''}>ป.ม.</option>
                                </select>`;
                            return select;
                        }
                    }
                ]
            });
        }

        function generateDataTable(formData) {
            $.post({
                url: '<?= site_url('admin_typical_ribbon/ajax_get_person_bdec') ?>',
                data: formData,
                dataType: 'json',
            }).done(res => {
                drawDataTable(res);
            }).fail((jhr, status, error) => console.error(jhr, status, error));
        }

        $("#search-form").submit(function(event) {
            event.preventDefault();

            $("#search-result").text('Loading...');
            let formData = $(this).serialize();
            generateDataTable(formData);
        });

        $(document).on("change", ".medal-name", function() {
            let formData = {
                id: $(this).parent('td').siblings('.biog-id').text(),
                medal: $(this).parent('td').siblings('.medal').text(),
                nextMedal: $(this).val()
            };

            $.post({
                url: '<?= site_url('admin_typical_ribbon/ajax_update_medal_bdec') ?>',
                data: formData,
                dataType: 'json'
            }).done(res => {
                console.log(res);
                if (res.status) {
                    $("#data-result").prop('class', 'has-text-success');
                    $("#data-result").text(res.text);
                    
                } else {
                    $("#data-result").prop('class', 'has-text-warning');
                    $("#data-result").text(res.text);
                }

                setTimeout(() => {
                    $("#data-result").prop('class', '');
                    $("#data-result").text('');
                    let searchFormData = $("#search-form").serialize();
                    generateDataTable(searchFormData);
                }, 3000);
            }).fail((jhr, status, error) => console.error(jhr, status, error));
        });

    });
</script>