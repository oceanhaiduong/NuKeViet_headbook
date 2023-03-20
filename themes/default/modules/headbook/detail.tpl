<!-- BEGIN: main -->
<!-- BEGIN: view -->
<form action="{NV_BASE_SITEURL}index.php?{NV_LANG_VARIABLE}={NV_LANG_DATA}&amp;{NV_NAME_VARIABLE}={MODULE_NAME}&amp;{NV_OP_VARIABLE}={OP}" method="post">
    <div class="table-responsive">
        <table class="table table-striped table-bordered table-hover">
            <thead>
                <tr>
                    <th class="w100">{LANG.number}</th>
                    <th  >{LANG.headbook_id}</th>
                    <th class="text-center" style="width: 70px">{LANG.week_id}</th>
                    <th class="text-center">{LANG.order_name}</th>
                    <th class="text-center">{LANG.session}</th>
                    <th class="text-center" style="width: 60px">{LANG.times}</th>
                    <th class="text-center">{LANG.subject_id}</th>
                    <th class="text-center" style="width: 70px">{LANG.times_id}</th>
                    <th class="text-center" >{LANG.lesson_id}</th>
                    <th class="text-center">{LANG.comment}</th>
                    <th class="text-center">{LANG.point}</th>
                    <th class="text-center">{LANG.teacher_id}</th>
                </tr>
            </thead>
            <!-- BEGIN: generate_page -->
            <tfoot>
                <tr>
                    <td class="text-center" colspan="13">{NV_GENERATE_PAGE}</td>
                </tr>
            </tfoot>
            <!-- END: generate_page -->
            <tbody>
                <!-- BEGIN: loop -->
                <tr>
                    <td class="text-center"> {VIEW.number} </td>
                    <td class="text-center"> {VIEW.headbook_id} </td>
                    <td class="text-center"> {VIEW.week_id} </td>
                    <td class="text-center"> {VIEW.order_name} </td>
                    <td class="text-center"> {VIEW.session} </td>
                    <td class="text-center"> {VIEW.times} </td>
                    <td class="text-center"> {VIEW.subject_id} </td>
                    <td class="text-center"> {VIEW.times_id} </td>
                    <td class="text-center"> {VIEW.lesson_id} </td>
                    <td class="text-center"> {VIEW.comment} </td>
                    <td class="text-center"> {VIEW.point} </td>
                    <td class="text-center"> {VIEW.teacher_id} </td>
                </tr>
                <!-- END: loop -->
            </tbody>
        </table>
    </div>
</form>
<!-- END: view -->

<!-- END: main -->