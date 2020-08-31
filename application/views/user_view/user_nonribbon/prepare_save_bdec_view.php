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
                        <form id="before-form">
                            <div class="field is-horizontal">
                                <div class="field-label is-normal">
                                    <label class="label">หน่วย</label>
                                </div>

                                <div class="field-body">
                                    <div class="field">
                                        <div class="select is-fullwidth">
                                            <select id="unitid" name="unitid">
                                                <option value="<?= $unitID ?>"><?= $unitname ?></option>
                                            </select>
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
            $("a#save-person-ul-nonribbon").addClass('is-active');
        };
        init_func();

        $("#before-form").submit(function(event) {
            event.preventDefault();
            let formData = $(this).serialize();
            console.log(formData);

            $.post({
                url: '<?= site_url('user_non_ribbon/ajax_show_person_before_save_bdec') ?>',
                data: formData,
                dataType: 'json'
            }).done(res => {
                console.log(res);
            }).fail((jhr, status, error) => {
                console.error(jhr, status, error);
            });
            // $("#property-form-data").html('Loading...');           
        });
    });
</script>