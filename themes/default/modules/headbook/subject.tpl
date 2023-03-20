<!-- BEGIN: main -->
<!-- BEGIN: view -->
<form action="{NV_BASE_SITEURL}index.php?{NV_LANG_VARIABLE}={NV_LANG_DATA}&amp;{NV_NAME_VARIABLE}={MODULE_NAME}&amp;{NV_OP_VARIABLE}={OP}" method="post">
    <div class="table-responsive">
        <table class="table table-striped table-bordered table-hover">
            <thead>
                <tr>
                    <th class="w100">{LANG.number}</th>
                    <th>{LANG.subject_name}</th>
                    <th>{LANG.status}</th>
                    <th>{LANG.add_time}</th>
                    <th>{LANG.update_time}</th>
                </tr>
            </thead>
            <!-- BEGIN: generate_page -->
            <tfoot>
                <tr>
                    <td class="text-center" colspan="6">{NV_GENERATE_PAGE}</td>
                </tr>
            </tfoot>
            <!-- END: generate_page -->
            <tbody>
                <!-- BEGIN: loop -->
                <tr>
                    <td class="text-center"> {VIEW.number} </td>
                    <td class="text-center"> {VIEW.subject_name} </td>
                    <td class="text-center"> {VIEW.status} </td>
                    <td class="text-center"> {VIEW.add_time} </td>
                    <td class="text-center"> {VIEW.update_time} </td>
                </tr>
                <!-- END: loop -->
            </tbody>
        </table>
    </div>
</form>
<!-- END: view -->

<!-- END: main -->