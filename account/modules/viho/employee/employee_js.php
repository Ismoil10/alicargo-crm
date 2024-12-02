<script>
    $(document).ready(function() {
        add_modal = function() {
            $('#addModal').modal("show");
        }

        filterModal = function() {
            $('#filterModal').modal("show");
        }

        add_expence = function() {
            $("#addExpenceModal").modal("show");
        }

        delete_modal = function(id) {
            $("[name=deleteID]").val(id);
            $("#deleteModal").modal("show");
        }

        edit_modal = function(id) {
            formData = new FormData();
            formData.append("expenseId", id);
            js_ajax_post("employee/employee_detail_edit_form.php", formData).done(function(data) {
                $("#editModal").html(data);
                $("#editModal").modal("show");
            });
        }

    });
</script>