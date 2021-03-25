<section class="section" style="min-height: 500px">
    <div class="columns">
        <div class="column is-one-fifth">
            <?= $sidemenu ?>
        </div>
        <div class="column is-four-fifths">
            <div class="container">
                <div id="profile" class="container">
                    <div class="block">
                        <div class="is-size-4">ข้อมูลกำลังพล</div>
                        <div class="container content is-size-5"><?= $person['BIOG_NAME'] ?></div>
                    </div>
                    <div class="block box">
                        <div class="is-size-5">รายละเอียด</div>
                        <form id="person-detail-form">
                            <div class="field">
                                <label class="label">ชื่อ นามสกุล</label>
                                <div class="control">
                                    <input type="text" name="name" class="input column is-half" value="<?= $person['BIOG_NAME'] ?>">
                                </div>
                            </div>
                            <div class="field">
                                <label class="label">ยศ</label>
                                <div class="control">
                                    <div class="select">
                                        <select name="rank">
                                            <?php foreach ($ranks as $r) { ?>
                                                <?php
                                                $selected = ($person['BIOG_RANK'] == $r['CRAK_CODE'] && $person['BIOG_CDEP'] == $r['CRAK_CDEP_CODE']) ? 'selected' : '';
                                                ?>
                                                <option value="<?= $r['CRAK_CODE'] ?>" title="<?= $r['CRAK_NAME_FULL'] ?>" <?= $selected ?>><?= $r['CRAK_NAME_ACM'] ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="field">
                                <label class="label">ตำแหน่ง</label>
                                <div class="control">
                                    <input type="text" name="posnameFull" class="input" value="<?= $person['BIOG_POSNAME_FULL'] ?>">
                                </div>
                            </div>
                            <div class="field">
                                <label class="label">เงินเดือน</label>
                                <div class="control">
                                    <input type="text" name="salary" class="input column is-one-third" value="<?= $person['BIOG_SALARY'] ?>">
                                </div>
                            </div>
                            <div class="field">
                                <div class="columns">
                                    <div class="column is-one-third">
                                        <label class="label">ระดับ</label>
                                        <div class="control">
                                            <input type="text" name="slevel" class="input" value="<?= $person['BIOG_SLEVEL'] ?>">
                                        </div>
                                    </div>
                                    <div class="column is-one-third">
                                        <label class="label">ชั้น</label>
                                        <div class="control">
                                            <input type="text" name="sclass" class="input" value="<?= $person['BIOG_SCLASS'] ?>">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="field">
                                <div class="control">
                                    <input type="hidden" name="idp" value="<?= $person['BIOG_IDP'] ?>">
                                    <button class="button is-primary">Submit</button>
                                    <button class="button" type="reset">Reset</button>
                                </div>
                            </div>
                            <div class="field">
                                <div id="person-detail-form-result"></div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
    $(document).ready(function() {
        $("ul#typical-ribbon").removeClass('is-hidden');
        $("a#admin-typical-ribbon-fundation").addClass('is-active');


        $("#person-detail-form").submit(function(event) {
            event.preventDefault();
            let formData = $(this).serialize();
            $.post({
                url: '<?= site_url('admin_typical_ribbon_status_off/ajax_update_person_detail_back') ?>',
                data: formData,
                dataType: 'json'
            }).done(res => {
                console.log(res);
                if (res.status) {
                    $("#person-detail-form-result").prop('class', 'notification is-success');
                    $("#person-detail-form-result").text(res.text);
                } else {
                    $("#person-detail-form-result").prop('class', 'notification is-danger');
                    $("#person-detail-form-result").text(res.text);
                }

                setTimeout(() => {
                    $("#person-detail-form-result").prop('class', '');
                    $("#person-detail-form-result").text('');
                }, 2500);
            }).fail((jhr, status, error) => console.error(jhr, status, error));

        });

    });
</script>