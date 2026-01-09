$(document).ready(function() {
    // let data = "interested_candidate_desc_";
    const base_url = $('#base_url').val();
    const career_uid = $('#career_uid').val();


    $.ajax({
        url: `${base_url}/admin/get-language-by-listing?career_uid=${career_uid}`,
        contentType: false,
        processData: false,
        type: 'GET',
        success: function(data) {
            if (data.includes('success')) {
                const language_list = JSON.parse(data).language_list;

                // for (let i = 0; i < language_list.length; i++) {
                    // lang_codes.push(language_list[i].language.code);
                //     if(language_list[i].language != null){
                //     CKEDITOR.replace(
                //         `interested_candidate_desc_${language_list[i].language.code}`);
                // }
            // }
            }
        },
        error: function(data) {
            console.log(data);
        }
    });
});