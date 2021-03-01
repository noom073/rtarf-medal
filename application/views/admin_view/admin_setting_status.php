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
                    <div class="block">สถานะ ระบบ</div>
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
            console.log(status);
        });


        $(document).on('click', "#on-system", function() {
            $.get({
                url: '<?= site_url('admin/ajax_on_system_status') ?>',
                dataType: 'json'
            }).done(res => {
                console.log(res);
            }).fail((jhr, status, error) => console.error(jhr, status, error));
        });


        $(document).on('click', "#off-system", function() {
            $.get({
                url: '<?= site_url('admin/ajax_off_system_status') ?>',
                dataType: 'json'
            }).done(res => {
                console.log(res);
            }).fail((jhr, status, error) => console.error(jhr, status, error));
        });
    });
</script>