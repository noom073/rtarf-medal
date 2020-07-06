<aside class="menu">
    <p class="menu-label">ข้อมูลพื้นฐาน</p>
    <ul class="menu-list">
        <li><a href="<?= site_url('admin_fundamental/index') ?>">ประวัติบุคคล</a></li>
        <li>
            <a class="has-dropdown">บัญชี <i class="fas fa-angle-down" aria-hidden="true"></i></a>
            <ul class="is-hidden" id="fdmt-report-ul">
                <li><a id="fdmt-report-ul-ribbon" href="<?= site_url('admin_fundamental/ribbon_report') ?>">บัญชีการรับเครื่องราชฯ สายสะพาย</a></li>
                <li><a id="fdmt-report-ul-non-ribbon" href="<?= site_url('admin_fundamental/non_ribbon_report') ?>">บัญชีการรับเครื่องราชฯ ต่ำกว่าสายสะพาย</a></li>
                <li><a id="fdmt-report-ul-not-req-medal" href="<?= site_url('admin_fundamental/not_request_medal') ?>">บัญชีผู้ยังไม่ได้รับเครื่องราชฯ</a></li>
            </ul>
        </li>
    </ul>

    <p class="menu-label">ชั้นสายสะพาย</p>
    <ul class="menu-list">
        <li><a id="people-property-ul-ribbon" href="<?= site_url('admin_ribbon/property_form') ?>">พิมพ์บัญชีแสดงคุณสมบัติ</a></li>
        <li><a id="summarize-name-ul-ribbon" href="<?= site_url('admin_ribbon/summarize_name_form') ?>">พิมพ์สรุปราบชื่อ</a></li>
        <li><a id="amount-person-ul-ribbon" href="<?= site_url('admin_ribbon/ribbon_amount') ?>">พิมพ์สรุปจำนวน</a></li>
    </ul>

    <p class="menu-label">ชั้นต่ำกว่าสายสะพาย</p>
    <ul class="menu-list">
        <li><a id="people-property-ul-nonribbon" href="<?= site_url('admin_non_ribbon/index') ?>">พิมพ์บัญชีแสดงคุณสมบัติ</a></li>
        <li><a id="summarize-name-ul-nonribbon" href="<?= site_url('admin_non_ribbon/summarize_name') ?>">พิมพ์สรุปราบชื่อ</a></li>
        <li><a>พิมพ์สรุปจำนวน</a></li>
        <li><a>พิมพ์บัญชีเสนอขอ รจม.</a></li>
        <li><a>พิมพ์บัญชีรายชื่อ รจม.</a></li>
    </ul>

    <p class="menu-label">ขอเครื่องราชฯ เพิ่มเติม</p>
    <ul class="menu-list">
        <li>
            <a class="has-dropdown">รอบโปรดเกล้าฯ <i class="fas fa-angle-down" aria-hidden="true"></i></a>
            <ul class="is-hidden">
                <li><a>รอบโปรดเกล้าฯ ข้อมูลพื้นฐาน</a></li>
                <li><a>รอบโปรดเกล้าฯ พิมพ์บัญชีแสดงคุณสมบัติ</a></li>
                <li><a>รอบโปรดเกล้าฯ พิมพ์บัญชีสรุปรายชื่อ</a></li>
                <li><a>รอบโปรดเกล้าฯ พิมพ์บัญชีสรุปจำนวน</a></li>
            </ul>
        </li>

        <li>
            <a class="has-dropdown">รอบปกติ ชั้นสายสะพาย <i class="fas fa-angle-down" aria-hidden="true"></i></a>
            <ul class="is-hidden">
                <li><a>รอบปกติ ชั้นสายสะพาย ข้อมูลพื้นฐาน</a></li>
                <li><a>รอบปกติ ชั้นสายสะพาย พิมพ์บัญชีแสดงคุณสมบัติ</a></li>
                <li><a>รอบปกติ ชั้นสายสะพาย พิมพ์บัญชีสรุปรายชื่อ</a></li>
                <li><a>รอบปกติ ชั้นสายสะพาย พิมพ์บัญชีสรุปจำนวน</a></li>
            </ul>
        </li>

        <li>
            <a class="has-dropdown">รอบปกติ ชั้นต่ำกว่าสายสะพาย <i class="fas fa-angle-down" aria-hidden="true"></i></a>
            <ul class="is-hidden">
                <li><a>รอบปกติ ชั้นต่ำกว่าสายสะพาย ข้อมูลพื้นฐาน</a></li>
                <li><a>รอบปกติ ชั้นต่ำกว่าสายสะพาย พิมพ์บัญชีแสดงคุณสมบัติ</a></li>
                <li><a>รอบปกติ ชั้นต่ำกว่าสายสะพาย พิมพ์บัญชีสรุปรายชื่อ</a></li>
                <li><a>รอบปกติ ชั้นต่ำกว่าสายสะพาย พิมพ์บัญชีสรุปจำนวน</a></li>
            </ul>
        </li>

    </ul>

    <p class="menu-label">ปรับฐานข้อมูลเครื่องราชฯ</p>
    <ul class="menu-list">
        <li><a>ปรับฐานข้อมูลเครื่องราชฯ</a></li>
    </ul>
</aside>

<script>
    $(document).ready(function() {
        $(".has-dropdown").click(function() {
            $(this).siblings("ul").toggleClass('is-hidden')
        });
    });
</script>