const delete_section_content = (div_id, section_id) => {
    console.log('div id ' + div_id);
    $("#modal_section_delete").modal("toggle");
    $(`#${div_id}`).remove();
};
