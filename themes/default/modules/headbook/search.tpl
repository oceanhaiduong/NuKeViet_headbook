<!-- BEGIN: main -->
<!-- BEGIN: view -->
<form action="{NV_BASE_SITEURL}index.php?{NV_LANG_VARIABLE}={NV_LANG_DATA}&amp;{NV_NAME_VARIABLE}={MODULE_NAME}&amp;{NV_OP_VARIABLE}={OP}" method="post">
    <div class="table-responsive">
        <table class="table table-striped table-bordered table-hover">
            <thead>
                <tr>
                    <th class="w100 text-center">{LANG.number}</th>
                    <th class="text-center">{LANG.class_name}</th>
                    <th class="text-center">{LANG.grade_id}</th>
                    <th class="text-center">{LANG.amount}</th>
                    <th class="text-center">{LANG.teacher_id}</th>
                    <th class="text-center">{LANG.add_time}</th>
                    <th class="text-center">{LANG.update_time}</th>
                </tr>
            </thead>
            <!-- BEGIN: generate_page -->
            <tfoot>
                <tr>
                    <td class="text-center" colspan="8">{NV_GENERATE_PAGE}</td>
                </tr>
            </tfoot>
            <!-- END: generate_page -->
            <tbody>
                <!-- BEGIN: loop -->
                <tr>
                    <td class="text-center">  {VIEW.number} </td>
                    <td class="text-center">  {VIEW.class_name} </td>
                    <td class="text-center">  {VIEW.grade_id} </td>
                    <td class="text-center">  {VIEW.amount} </td>
                    <td class="text-center">  {VIEW.teacher_id} </td>
                    <td class="text-center">  {VIEW.add_time} </td>
                    <td class="text-center">  {VIEW.update_time} </td>
                </tr>
                <!-- END: loop -->
            </tbody>
        </table>
    </div>
</form>
<!-- END: view -->

<!-- END: main -->