<script>
    $(document).ready(function() {
        filterModal = function() {
        $('#filterModal').modal("show");
    }

        add_modal = function() {
            $("#addModal").modal("show");
        }

        delete_modal = function(id) {
            $("[name=deleteID]").val(id);
            $("#deleteModal").modal("show");
        }

        edit_modal = function(id) {
            formData = new FormData();
            formData.append("adminId", id);
            js_ajax_post("adminka/adminka_edit_form.php", formData).done(function(data) {
                $("#editModal").html(data);
                $("#editModal").modal("show");
            });
        }

    });
</script>