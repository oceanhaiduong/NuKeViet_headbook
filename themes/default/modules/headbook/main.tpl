<!-- BEGIN: main -->
<!-- BEGIN: view -->
   <h1 class="text-center" style="font-size: 20px; margin-bottom: 20px">Danh sách sổ đầu bài</h1>   
<form action="{NV_BASE_SITEURL}index.php?{NV_LANG_VARIABLE}={NV_LANG_DATA}&amp;{NV_NAME_VARIABLE}={MODULE_NAME}&amp;{NV_OP_VARIABLE}={OP}" method="post">
    <div class="table-responsive">
        <table class="table table-striped table-bordered table-hover">
            <thead>
                <tr>
                    <th class="w100 text-center">{LANG.number}</th>
                    <th class="text-center" >{LANG.headbook_name}</th>
                    <th class="text-center">{LANG.class_id}</th>
                    <th class="text-center">{LANG.year_id}</th>
                    <th class="text-center">{LANG.status}</th>
                    <th class="text-center">{LANG.add_time}</th>
                    <th class="text-center">{LANG.update_time}</th>
                    <th class="text-center">{LANG.detail_main}</th>
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
                    <td class="text-center"> {VIEW.number} </td>
                    <td class="text-center"> {VIEW.headbook_name} </td>
                    <td> {VIEW.class_id} </td>
                    <td class="text-center"> {VIEW.year_id} </td>
                    <td class="text-center"> {VIEW.status} </td>
                    <td class="text-center"> {VIEW.add_time} </td>
                    <td class="text-center"> {VIEW.update_time} </td>
                    <td class="text-center"><i class="fa fa-edit fa-lg">&nbsp;</i> <a href="{VIEW.link_edit}#edit">{LANG.view}</a></td>
                </tr>
                <!-- END: loop -->
            </tbody>
        </table>
    </div>
</form>
<!-- END: view -->

<!-- END: main -->