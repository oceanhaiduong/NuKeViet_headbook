<!-- BEGIN: main -->
<!-- BEGIN: view -->
<form action="{NV_BASE_SITEURL}index.php?{NV_LANG_VARIABLE}={NV_LANG_DATA}&amp;{NV_NAME_VARIABLE}={MODULE_NAME}&amp;{NV_OP_VARIABLE}={OP}" method="post">
    <div class="table-responsive">
        <table class="table table-striped table-bordered table-hover">
            <thead>
                <tr>
                    <th class="w100 text-cente">{LANG.number}</th>
                    <th class="text-center"  style="width: 80px">{LANG.times_id}</th>
                    <th class="text-center" >{LANG.lesson_id}</th>
                    <th class="text-center"  style="width: 130px">{LANG.subject_id}</th>
                    <th class="text-center"  style="width: 70px">{LANG.grade_id}</th>
                    <th class="text-center"  style="width: 100px">{LANG.year_id}</th>
                </tr>
            </thead>
            <!-- BEGIN: generate_page -->
            <tfoot>
                <tr>
                    <td class="text-center" colspan="7">{NV_GENERATE_PAGE}</td>
                </tr>
            </tfoot>
            <!-- END: generate_page -->
            <tbody>
                <!-- BEGIN: loop -->
                <tr>
                    <td  class="text-center"> {VIEW.number} </td>
                    <td  class="text-center"> {VIEW.times_id} </td>
                    <td  class="text-center"> {VIEW.lesson_id} </td>
                    <td  class="text-center"> {VIEW.subject_id} </td>
                    <td  class="text-center"> {VIEW.grade_id} </td>
                    <td  class="text-center"> {VIEW.year_id} </td>
                </tr>
                <!-- END: loop -->
            </tbody>
        </table>
    </div>
</form>
<!-- END: view -->

<!-- END: main -->