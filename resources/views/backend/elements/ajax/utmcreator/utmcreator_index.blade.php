<script type="text/javascript">
$(document).ready(function(){

    $('#admin-form')[0].reset();

    $("#Muipaper_Success").hide();
    $("#Muipaper_FilloutURL").hide();

    var website_url = '';
    website_url = $("#website_url").val();

    var campaign_source = '';
    campaign_source = $.trim($("#campaign_source :selected").text());

    var campaign_medium = '';
    campaign_medium = $.trim($("#campaign_medium :selected").text());

    var campaign_name = '';
    campaign_name = $.trim($("#campaign_name :selected").text());

    var campaign_id = '';
    campaign_id = $("#campaign_id").val();

    var campaign_term = '';
    campaign_term = $("#campaign_term").val();

    var campaign_content = '';
    campaign_content = $("#campaign_content").val();

    var generated_url = '';
    generated_url = $("#generated_url").val();

    $("#website_url").keyup(function(event){
        website_url = $(this).val();
        campaign_source = $.trim($("#campaign_source :selected").text());
        campaign_medium = $.trim($("#campaign_medium :selected").text());
        campaign_name = $.trim($("#campaign_name :selected").text());
        campaign_id = $("#campaign_id").val();
        campaign_term = $("#campaign_term").val();
        campaign_content = $("#campaign_content").val();
        generated_url = $("#generated_url").val();
        if(website_url.startsWith('http://') || website_url.startsWith('https://'))
        {
            if(validURL(website_url))
            {
                if(campaign_source != '')
                {
                    $("#Muipaper_badURL").hide();
                    $("#Muipaper_FilloutURL").hide();
                    if(campaign_source != '')
                    {
                        generated_url = website_url + '?utm_source=' + campaign_source;
                        if(campaign_medium != '')
                        {
                            generated_url = generated_url + '&utm_medium=' + campaign_medium;
                        }
                        if(campaign_name != '')
                        {
                            generated_url = generated_url + '&utm_campaign=' + campaign_name;
                        }
                        if(campaign_id != '')
                        {
                            generated_url = generated_url + '&utm_id=' + campaign_id;
                        }
                        if(campaign_term != '')
                        {
                            generated_url = generated_url + '&utm_term=' + campaign_term;
                        }
                        if(campaign_content != '')
                        {
                            generated_url = generated_url + '&utm_content=' + campaign_content;
                        }
                    }
                    $("#generated_url").val(generated_url);
                    $("#Muipaper_Success").show();
                }
                else
                {
                    $("#Muipaper_badURL").hide();
                    $("#Muipaper_Success").hide();
                    $("#Muipaper_FilloutURL").show();
                }
            }
            else
            {
                $("#Muipaper_badURL").show();
                $("#Muipaper_Success").hide();
                $("#Muipaper_FilloutURL").hide();
            }
        }
        else
        {
            $("#Muipaper_badURL").show();
            $("#Muipaper_Success").hide();
            $("#Muipaper_FilloutURL").hide();
        }
    });

    $("#campaign_source").on('change', function(){
        campaign_source = $.trim($(this).find(":selected").text());
        website_url = $("#website_url").val();
        campaign_medium = $.trim($("#campaign_medium :selected").text());
        campaign_name = $.trim($("#campaign_name :selected").text());
        campaign_id = $("#campaign_id").val();
        campaign_term = $("#campaign_term").val();
        campaign_content = $("#campaign_content").val();
        generated_url = $("#generated_url").val();
        if(website_url.startsWith('http://') || website_url.startsWith('https://'))
        {
            if(validURL(website_url))
            {
                if(campaign_source != '')
                {
                    $("#Muipaper_badURL").hide();
                    $("#Muipaper_FilloutURL").hide();
                    if(campaign_source != '')
                    {
                        generated_url = website_url + '?utm_source=' + campaign_source;
                        if(campaign_medium != '')
                        {
                            generated_url = generated_url + '&utm_medium=' + campaign_medium;
                        }
                        if(campaign_name != '')
                        {
                            generated_url = generated_url + '&utm_campaign=' + campaign_name;
                        }
                        if(campaign_id != '')
                        {
                            generated_url = generated_url + '&utm_id=' + campaign_id;
                        }
                        if(campaign_term != '')
                        {
                            generated_url = generated_url + '&utm_term=' + campaign_term;
                        }
                        if(campaign_content != '')
                        {
                            generated_url = generated_url + '&utm_content=' + campaign_content;
                        }
                    }
                    $("#generated_url").val(generated_url);
                    $("#Muipaper_Success").show();
                }
                else
                {
                    $("#Muipaper_badURL").hide();
                    $("#Muipaper_Success").hide();
                    $("#Muipaper_FilloutURL").show();
                }
            }
            else
            {
                $("#Muipaper_badURL").show();
                $("#Muipaper_Success").hide();
                $("#Muipaper_FilloutURL").hide();
            }
        }
        else
        {
            $("#Muipaper_badURL").show();
            $("#Muipaper_Success").hide();
            $("#Muipaper_FilloutURL").hide();
        }
    });

    $("#campaign_medium").on('change', function(){
        campaign_medium = $.trim($(this).find(":selected").text());
        website_url = $("#website_url").val();
        campaign_source = $.trim($("#campaign_source :selected").text());
        campaign_name = $.trim($("#campaign_name :selected").text());
        campaign_id = $("#campaign_id").val();
        campaign_term = $("#campaign_term").val();
        campaign_content = $("#campaign_content").val();
        generated_url = $("#generated_url").val();
        if(website_url.startsWith('http://') || website_url.startsWith('https://'))
        {
            if(validURL(website_url))
            {
                if(campaign_source != '')
                {
                    $("#Muipaper_badURL").hide();
                    $("#Muipaper_FilloutURL").hide();
                    if(campaign_source != '')
                    {
                        generated_url = website_url + '?utm_source=' + campaign_source;
                        if(campaign_medium != '')
                        {
                            generated_url = generated_url + '&utm_medium=' + campaign_medium;
                        }
                        if(campaign_name != '')
                        {
                            generated_url = generated_url + '&utm_campaign=' + campaign_name;
                        }
                        if(campaign_id != '')
                        {
                            generated_url = generated_url + '&utm_id=' + campaign_id;
                        }
                        if(campaign_term != '')
                        {
                            generated_url = generated_url + '&utm_term=' + campaign_term;
                        }
                        if(campaign_content != '')
                        {
                            generated_url = generated_url + '&utm_content=' + campaign_content;
                        }
                    }
                    $("#generated_url").val(generated_url);
                    $("#Muipaper_Success").show();
                }
                else
                {
                    $("#Muipaper_badURL").hide();
                    $("#Muipaper_Success").hide();
                    $("#Muipaper_FilloutURL").show();
                }
            }
            else
            {
                $("#Muipaper_badURL").show();
                $("#Muipaper_Success").hide();
                $("#Muipaper_FilloutURL").hide();
            }
        }
        else
        {
            $("#Muipaper_badURL").show();
            $("#Muipaper_Success").hide();
            $("#Muipaper_FilloutURL").hide();
        }
    });

    $("#campaign_name").on('change', function(){
        campaign_name = $.trim($(this).find(":selected").text());
        website_url = $("#website_url").val();
        campaign_source = $.trim($("#campaign_source :selected").text());
        campaign_medium = $.trim($("#campaign_medium :selected").text());
        campaign_id = $("#campaign_id").val();
        campaign_term = $("#campaign_term").val();
        campaign_content = $("#campaign_content").val();
        generated_url = $("#generated_url").val();
        if(website_url.startsWith('http://') || website_url.startsWith('https://'))
        {
            if(validURL(website_url))
            {
                if(campaign_source != '')
                {
                    $("#Muipaper_badURL").hide();
                    $("#Muipaper_FilloutURL").hide();
                    if(campaign_source != '')
                    {
                        generated_url = website_url + '?utm_source=' + campaign_source;
                        if(campaign_medium != '')
                        {
                            generated_url = generated_url + '&utm_medium=' + campaign_medium;
                        }
                        if(campaign_name != '')
                        {
                            generated_url = generated_url + '&utm_campaign=' + campaign_name;
                        }
                        if(campaign_id != '')
                        {
                            generated_url = generated_url + '&utm_id=' + campaign_id;
                        }
                        if(campaign_term != '')
                        {
                            generated_url = generated_url + '&utm_term=' + campaign_term;
                        }
                        if(campaign_content != '')
                        {
                            generated_url = generated_url + '&utm_content=' + campaign_content;
                        }
                    }
                    $("#generated_url").val(generated_url);
                    $("#Muipaper_Success").show();
                }
                else
                {
                    $("#Muipaper_badURL").hide();
                    $("#Muipaper_Success").hide();
                    $("#Muipaper_FilloutURL").show();
                }
            }
            else
            {
                $("#Muipaper_badURL").show();
                $("#Muipaper_Success").hide();
                $("#Muipaper_FilloutURL").hide();
            }
        }
        else
        {
            $("#Muipaper_badURL").show();
            $("#Muipaper_Success").hide();
            $("#Muipaper_FilloutURL").hide();
        }
    });

    $("#campaign_id").keyup(function(event){
        campaign_id = $(this).val();
        website_url = $("#website_url").val();
        campaign_source = $.trim($("#campaign_source :selected").text());
        campaign_medium = $.trim($("#campaign_medium :selected").text());
        campaign_name = $.trim($("#campaign_name :selected").text());
        campaign_term = $("#campaign_term").val();
        campaign_content = $("#campaign_content").val();
        generated_url = $("#generated_url").val();
        if(website_url.startsWith('http://') || website_url.startsWith('https://'))
        {
            if(validURL(website_url))
            {
                if(campaign_source != '')
                {
                    $("#Muipaper_badURL").hide();
                    $("#Muipaper_FilloutURL").hide();
                    if(campaign_source != '')
                    {
                        generated_url = website_url + '?utm_source=' + campaign_source;
                        if(campaign_medium != '')
                        {
                            generated_url = generated_url + '&utm_medium=' + campaign_medium;
                        }
                        if(campaign_name != '')
                        {
                            generated_url = generated_url + '&utm_campaign=' + campaign_name;
                        }
                        if(campaign_id != '')
                        {
                            generated_url = generated_url + '&utm_id=' + campaign_id;
                        }
                        if(campaign_term != '')
                        {
                            generated_url = generated_url + '&utm_term=' + campaign_term;
                        }
                        if(campaign_content != '')
                        {
                            generated_url = generated_url + '&utm_content=' + campaign_content;
                        }
                    }
                    $("#generated_url").val(generated_url);
                    $("#Muipaper_Success").show();
                }
                else
                {
                    $("#Muipaper_badURL").hide();
                    $("#Muipaper_Success").hide();
                    $("#Muipaper_FilloutURL").show();
                }
            }
            else
            {
                $("#Muipaper_badURL").show();
                $("#Muipaper_Success").hide();
                $("#Muipaper_FilloutURL").hide();
            }
        }
        else
        {
            $("#Muipaper_badURL").show();
            $("#Muipaper_Success").hide();
            $("#Muipaper_FilloutURL").hide();
        }
    });

    $("#campaign_term").keyup(function(event){
        campaign_term = $(this).val();
        website_url = $("#website_url").val();
        campaign_source = $.trim($("#campaign_source :selected").text());
        campaign_medium = $.trim($("#campaign_medium :selected").text());
        campaign_name = $.trim($("#campaign_name :selected").text());
        campaign_id = $("#campaign_id").val();
        campaign_content = $("#campaign_content").val();
        generated_url = $("#generated_url").val();
        if(website_url.startsWith('http://') || website_url.startsWith('https://'))
        {
            if(validURL(website_url))
            {
                if(campaign_source != '')
                {
                    $("#Muipaper_badURL").hide();
                    $("#Muipaper_FilloutURL").hide();
                    if(campaign_source != '')
                    {
                        generated_url = website_url + '?utm_source=' + campaign_source;
                        if(campaign_medium != '')
                        {
                            generated_url = generated_url + '&utm_medium=' + campaign_medium;
                        }
                        if(campaign_name != '')
                        {
                            generated_url = generated_url + '&utm_campaign=' + campaign_name;
                        }
                        if(campaign_id != '')
                        {
                            generated_url = generated_url + '&utm_id=' + campaign_id;
                        }
                        if(campaign_term != '')
                        {
                            generated_url = generated_url + '&utm_term=' + campaign_term;
                        }
                        if(campaign_content != '')
                        {
                            generated_url = generated_url + '&utm_content=' + campaign_content;
                        }
                    }
                    $("#generated_url").val(generated_url);
                    $("#Muipaper_Success").show();
                }
                else
                {
                    $("#Muipaper_badURL").hide();
                    $("#Muipaper_Success").hide();
                    $("#Muipaper_FilloutURL").show();
                }
            }
            else
            {
                $("#Muipaper_badURL").show();
                $("#Muipaper_Success").hide();
                $("#Muipaper_FilloutURL").hide();
            }
        }
        else
        {
            $("#Muipaper_badURL").show();
            $("#Muipaper_Success").hide();
            $("#Muipaper_FilloutURL").hide();
        }
    });

    $("#campaign_content").keyup(function(event){
        campaign_content = $(this).val();
        website_url = $("#website_url").val();
        campaign_source = $.trim($("#campaign_source :selected").text());
        campaign_medium = $.trim($("#campaign_medium :selected").text());
        campaign_name = $.trim($("#campaign_name :selected").text());
        campaign_id = $("#campaign_id").val();
        campaign_term = $("#campaign_term").val();
        generated_url = $("#generated_url").val();
        if(website_url.startsWith('http://') || website_url.startsWith('https://'))
        {
            if(validURL(website_url))
            {
                if(campaign_source != '')
                {
                    $("#Muipaper_badURL").hide();
                    $("#Muipaper_FilloutURL").hide();
                    if(campaign_source != '')
                    {
                        generated_url = website_url + '?utm_source=' + campaign_source;
                        if(campaign_medium != '')
                        {
                            generated_url = generated_url + '&utm_medium=' + campaign_medium;
                        }
                        if(campaign_name != '')
                        {
                            generated_url = generated_url + '&utm_campaign=' + campaign_name;
                        }
                        if(campaign_id != '')
                        {
                            generated_url = generated_url + '&utm_id=' + campaign_id;
                        }
                        if(campaign_term != '')
                        {
                            generated_url = generated_url + '&utm_term=' + campaign_term;
                        }
                        if(campaign_content != '')
                        {
                            generated_url = generated_url + '&utm_content=' + campaign_content;
                        }
                    }
                    $("#generated_url").val(generated_url);
                    $("#Muipaper_Success").show();
                }
                else
                {
                    $("#Muipaper_badURL").hide();
                    $("#Muipaper_Success").hide();
                    $("#Muipaper_FilloutURL").show();
                }
            }
            else
            {
                $("#Muipaper_badURL").show();
                $("#Muipaper_Success").hide();
                $("#Muipaper_FilloutURL").hide();
            }
        }
        else
        {
            $("#Muipaper_badURL").show();
            $("#Muipaper_Success").hide();
            $("#Muipaper_FilloutURL").hide();
        }
    }); 
});                   
</script>