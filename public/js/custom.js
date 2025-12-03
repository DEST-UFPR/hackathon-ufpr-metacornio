$(document).ready(function() {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    function detectMob() {
        const toMatch = [
            /Android/i,
            /webOS/i,
            /iPhone/i,
            /iPad/i,
            /iPod/i,
            /BlackBerry/i,
            /Windows Phone/i
        ];
        
        return toMatch.some((toMatchItem) => {
            return navigator.userAgent.match(toMatchItem);
        });
    }

    isMobile = detectMob();

    /* Tratamento Sidebar */
    $(".MenuItem a").click(function() {
        $(this).parent(".MenuItem").children("ul").slideToggle("100");
        $(this).find(".IconSub").toggleClass("fa-caret-up fa-caret-down");
    });
    $("#sidebarCollapse").click(function() {
        $('#SideBarNav').toggleClass('active');
        $('#SideBarContent').toggleClass('active');
    });
    $(".MenuItem a").click(function() {
        $(".tooltip").remove();
    });

    /* Sidebar Active */
    var route = $("#route").val();
    var menu_item = $("#SideBarNav").find(`[data-route='${route}']`);
    if(menu_item.parent().parent().children("ul").hasClass("divMenuSub")){
        menu_item.parent().css("display", "block");
        menu_item.parent().parent().addClass("active");
        menu_item.parent().parent().find('a').find('.IconSub').toggleClass("fa-caret-down fa-caret-up");
    }
    menu_item.addClass("active");

    /* Menu Construção */
    $(document).on("click", ".SMenuItem a", function(){
        if($(this).attr("href") == "#"){
            var html = `
                <p style="margin-top: 1em">
                    <i class="fa-duotone fa-triangle-person-digging" style="font-size: 3em"></i>
                </p>
                <h4>EM CONSTRUÇÃO</h4>
            `;
            Swal.fire({
                html: html,
                allowOutsideClick: false,
                showCancelButton: true,
                showConfirmButton: false,
                cancelButtonColor: '#2a2b38',
                cancelButtonText: 'CONTINUAR'
            });
        }
    });

    /* Tooltips BS5 */
    function load_tt(){
        $(".tooltip").remove();
        let tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl, {
                container: 'body',
                trigger: 'hover'
            });
        })
    };
    load_tt();

    /* Loading Overlay */
    function load_ov(mode){
        if(mode == "show"){
            $(".spanner").addClass("show");
            $(".overlay").addClass("show");
        }
        else if(mode == "hide"){
            $(".spanner").removeClass("show");
            $(".overlay").removeClass("show");
        }
    };

    /* Função para mostrar/esconder senha */
    function tooglePassword(input, icon){
        var tipoInput = input.attr('type') === 'password' ? 'text' : 'password';
        input.attr("type", tipoInput);
        icon.toggleClass("fa-eye fa-eye-slash");
    };

    var pathname = window.location.pathname;
    var patharray = ["", "/app-termos-e-condicoes", "/app-politica-privacidade", "/solicitacao-exclusao", "/prePainel", "/cadastro/consumidor", "/cadastro/participante", "/aprovar-solicitacao"];
    if(jQuery.inArray(pathname, patharray) == -1){
        $.extend(true, $.fn.dataTable.defaults, {
            language: {
                url: 'plugin/DataTables/pt-BR.json',
                "decimal": ",",
                "thousands": ".",
            },
            dom: '<"top"f>rt<"bottom"lip>',
            lengthMenu: [
                [5, 10, 25, 50],
                [5, 10, 25, 50],
            ],
        });
    };

    /* Format DateTime */
    function formatDateTime(dateStr) {
        dateStr = dateStr.replace('T', ' ');
        var arrDateTime = dateStr.split(" ");
        var arrDates = arrDateTime[0].split("-");
        return arrDates[2]+'/'+arrDates[1]+'/'+arrDates[0]+' '+arrDateTime[1];
    };

    $(document).on('keypress',function(e) {
        if(e.which == 13) {
            var checkForm = e.currentTarget.activeElement.form.id;
            if(checkForm){
                switch(checkForm){
                    case 'form-login':
                        e.preventDefault();
                        $(`#${checkForm}`).next().find('.btn-login').trigger('click');
                    break;
                    default:
                        e.preventDefault();
                        $(`#${checkForm}`).offsetParent().next('.modal-footer').find('.btn-save').trigger("click");
                    break;
                }
            }
        }
    });

    /* Botão para ver detalhes do registro */
    $(document).on("click", ".btn-ver", function(){
        var route = $(this).data('route');
        var dados = $(this).parent().parent().parent().attr("id");
        var target = $(this).data('target');
        var form = new FormData();
        form.append("id", dados);

        load_ov('show');

        $.ajax({
            url: route,
            type: 'POST',
            data: form,
            cache: false,
            contentType: false,
            processData: false,
            success: (data) => {
                $(target+" .modal-content").html(data.html);
                load_ov('hide');
                load_tt();

                $(target).modal('show');
            },
            error: (err) => {
                load_ov('hide');
                var check = checkSession(err);

                if(!check){
                    Swal.fire({
                        icon: 'error',
                        title: err.responseJSON.data
                    });
                }
            }
        });
    });

    /* Função para validação de sessão */
    function checkSession(error){
        if(error.status == 419 || error.status == 403 || error.status == 401){
            var index = window.location.origin;
            Swal.fire({
                title: 'Sessão Expirada!',
                text: "Clique em CONTINUAR para efetuar o login novamente!",
                icon: 'warning',
                allowOutsideClick: false,
                showCancelButton: false,
                confirmButtonColor: '#2a2b38',
                confirmButtonText: 'CONTINUAR'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.replace(index);
                }
            })
            return true;
        }
        else{
            return false;
        }
    };

    const Toast = Swal.mixin({
        toast: true,
        position: 'top-center',
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true,
        didOpen: (toast) => {
            toast.addEventListener('mouseenter', Swal.stopTimer)
            toast.addEventListener('mouseleave', Swal.resumeTimer)
        }
    });
});

if (!String.prototype.slugify) {
	String.prototype.slugify = function () {

	return  this.toString().toLowerCase()
	.replace(/[àÀáÁâÂãäÄÅåª]+/g, 'a')       // Special Characters #1
	.replace(/[èÈéÉêÊëË]+/g, 'e')       	// Special Characters #2
	.replace(/[ìÌíÍîÎïÏ]+/g, 'i')       	// Special Characters #3
	.replace(/[òÒóÓôÔõÕöÖº]+/g, 'o')       	// Special Characters #4
	.replace(/[ùÙúÚûÛüÜ]+/g, 'u')       	// Special Characters #5
	.replace(/[ýÝÿŸ]+/g, 'y')       		// Special Characters #6
	.replace(/[ñÑ]+/g, 'n')       			// Special Characters #7
	.replace(/[çÇ]+/g, 'c')       			// Special Characters #8
	.replace(/[ß]+/g, 'ss')       			// Special Characters #9
	.replace(/[Ææ]+/g, 'ae')       			// Special Characters #10
	.replace(/[Øøœ]+/g, 'oe')       		// Special Characters #11
	.replace(/[%]+/g, 'pct')       			// Special Characters #12
	.replace(/\s+/g, '-')           		// Replace spaces with -
    .replace(/[^\w\-]+/g, '')       		// Remove all non-word chars
    .replace(/\-\-+/g, '-')         		// Replace multiple - with single -
    .replace(/^-+/, '')             		// Trim - from start of text
    .replace(/-+$/, '');            		// Trim - from end of text
    
	};
}

// Full dimensão
(function($) {
    $.fn.matchDimensions = function(dimension) {
        var itemsToMatch = $(this),
        maxHeight = 0,
        maxWidth = 0;
        if (itemsToMatch.length > 0) {
            switch (dimension) {
                case "height":
                    itemsToMatch.css("height", "auto").each(function() {
                        maxHeight = Math.max(maxHeight, $(this).height());
                    }).height(maxHeight);
                break;
                case "width":
                    itemsToMatch.css("width", "auto").each(function() {
                        maxWidth = Math.max(maxWidth, $(this).width());
                    }).width(maxWidth);
                break;
                default:
                    itemsToMatch.each(function() {
                        var thisItem = $(this);
                        maxHeight = Math.max(maxHeight, thisItem.height());
                        maxWidth = Math.max(maxWidth, thisItem.width());
                    });
                    itemsToMatch
                        .css({
                        "width": "auto",
                        "height": "auto"
                        })
                        .height(maxHeight)
                        .width(maxWidth);
                break;
            }
        }
        return itemsToMatch;
    };
})(jQuery);