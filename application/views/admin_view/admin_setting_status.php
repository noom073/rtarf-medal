<section class="section">
    <div class="">
        <div class="columns">
            <div class="column is-one-quarter">
                <?= $sidemenu ?>
            </div>

            <div class="column is-three-quarter">
                <div class="container">
                    <div class="content is-size-4">กำหนดเปิด-ปิดระบบ</div>
                </div>
                <div class="container">
                    <div class="block">
                        สถานะระบบฯ ปัจจุบัน:
                        <span id="system-status"></span>
                    </div>
                    <div class="block">
                        <button id="off-system" class="button is-danger is-outlined">ปิด</button>
                        <button id="on-system" class="button is-success is-outlined">เปิด</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
    $(document).ready(function() {
        $("a#set-system-status").addClass('is-active');


        const getSystemStatus = () => {
            return $.get({
                url: '<?= site_url('admin/ajax_get_system_status') ?>',
                dataType: 'json'
            }).done().fail((jhr, status, error) => console.error(jhr, status, error));
        };


        $(async () => {
            let status = await getSystemStatus();
            console.log(status);;
            if (status.text == '1') {
                $("#on-system").prop('class', 'button is-success');
                $("#off-system").prop('class', 'button is-danger is-outlined');
                $("#system-status").prop('class', 'has-text-success');
                $("#system-status").text('เปิด');
            } else {
                $("#on-system").prop('class', 'button is-success is-outlined');
                $("#off-system").prop('class', 'button is-danger');
                $("#system-status").prop('class', 'has-text-danger');
                $("#system-status").text('ปิด');
            }
        });


        $(document).on('click', "#on-system", function() {
            $.get({
                url: '<?= site_url('admin/ajax_on_system_status') ?>',
                dataType: 'json'
            }).done(res => {
                if (res.text == '1') {
                    $("#on-system").prop('class', 'button is-success');
                    $("#off-system").prop('class', 'button is-danger is-outlined');
                    $("#system-status").prop('class', 'has-text-success');
                    $("#system-status").text('เปิด');
                } else {
                    $("#on-system").prop('class', 'button is-success is-outlined');
                    $("#off-system").prop('class', 'button is-danger');
                    $("#system-status").prop('class', 'has-text-danger');
                    $("#system-status").text('ปิด');
                }
            }).fail((jhr, status, error) => console.error(jhr, status, error));
        });


        $(document).on('click', "#off-system", function() {
            $.get({
                url: '<?= site_url('admin/ajax_off_system_status') ?>',
                dataType: 'json'
            }).done(res => {
                if (res.text == '0') {
                    $("#on-system").prop('class', 'button is-success is-outlined');
                    $("#off-system").prop('class', 'button is-danger');
                    $("#system-status").prop('class', 'has-text-danger');
                    $("#system-status").text('ปิด');
                } else {
                    $("#on-system").prop('class', 'button is-success');
                    $("#off-system").prop('class', 'button is-danger is-outlined');
                    $("#system-status").prop('class', 'has-text-success');
                    $("#system-status").text('เปิด');
                }
            }).fail((jhr, status, error) => console.error(jhr, status, error));
        });
    });
</script>