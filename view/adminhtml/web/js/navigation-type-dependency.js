require(['jquery'],
    function($) {

        $(document).ready(function()
        {
            var maxTime = 10000; // 10 seconds
            var time = 0;

            Array.prototype.move = function (old_index, new_index) {
                if (new_index >= this.length) {
                    var k = new_index - this.length;
                    while ((k--) + 1) {
                        this.push(undefined);
                    }
                }
                this.splice(new_index, 0, this.splice(old_index, 1)[0]);
                return this;
            };

            var interval = setInterval(function () {

                if(ready())
                {
                    setAttributes();
                    sortAttributeOptions();
                    clearInterval(interval);
                }
                else
                {
                    if (time > maxTime)
                    {
                        // still hidden, after 2 seconds, stop checking
                        clearInterval(interval);
                        return;
                    }

                    // not visible yet, do something
                    time += 100;
                }
            }, 200);

        });

        $('body').on('change', '[name="navigation_type"]', function () {
            setAttributes();
        });

        $('body').on('change', '[name="is_mega_menu"]', function () {
            setAttributes();
        });

        function ready()
        {
            flag = true;
            if($('[name="cms_page"]').length == 0) {
                flag = false;
            }
            if($('[name="static_link"]').length == 0) {
                flag = false;
            }
            if($('[name="mega_menu_attributes"]').length == 0) {
                flag = false;
            }
            if($('[name="navigation_type"]').length == 0) {
                flag = false;
            }
            if($('[name="promo_block"]').length == 0) {
                flag = false;
            }

            return flag;
        }

        function hideAll()
        {
            $('[name="cms_page"]').parents('.admin__field').hide();
            $('[name="static_link"]').parents('.admin__field').hide();
            $('[name="mega_menu_attributes"]').parents('.admin__field').hide();
            $('[name="promo_block"]').parents('.admin__field').hide();
        }

        function setAttributes() {
            navigationType = $('[name="navigation_type"]').val();

            if(navigationType == 'attribute')
            {
                hideAll();
                $('[name="mega_menu_attributes"]').parents('.admin__field').show();
            }
            else if(navigationType == 'cms_page')
            {
                hideAll();
                $('[name="cms_page"]').parents('.admin__field').show();
            }
            else if(navigationType == 'link')
            {
                hideAll();
                $('[name="static_link"]').parents('.admin__field').show();
            }
            else
            {
                hideAll();
            }

            if($('[name="is_mega_menu"]').val() == 1)
                $('[name="promo_block"]').parents('.admin__field').show();
            else
                $('[name="promo_block"]').parents('.admin__field').hide();
        }

        function sortAttributeOptions() {
            var theSelect = jQuery('[name="mega_menu_attributes"]');
            if (theSelect.length) {
                theSelect.find('option').each(function() {
                    switch($(this)[0].value) {
                        case 'construction_name':
                            putOptionInPosition(theSelect, $(this), 7);
                            break;
                        case 'brand_name':
                            putOptionInPosition(theSelect, $(this), 6);
                            break;
                        case 'origin_name':
                            putOptionInPosition(theSelect, $(this), 5);
                            break;
                        case 'vendor_name':
                            putOptionInPosition(theSelect, $(this), 4);
                            break;
                        case 'size_name':
                            putOptionInPosition(theSelect, $(this), 3);
                            break;
                        case 'style_name':
                            putOptionInPosition(theSelect, $(this), 2);
                            break;
                        case 'shape_name':
                            putOptionInPosition(theSelect, $(this), 1);
                            break;
                        case 'color_name':
                            putOptionInPosition(theSelect, $(this), 0);
                            break;
                        default:
                            putOptionInPosition(theSelect, $(this), 'last');
                    }
                });
            }
        }

        function putOptionInPosition(theSelect, theItem, theSort) {
            if (theSelect != null) {
                var singleVal = theItem[0].value;
                if (theSort === 'last') {
                    theSelect.find('option').last().after(theItem[0].outerHTML);
                } else {
                    theSelect.find('option:eq(' + theSort + ')').before(theItem[0].outerHTML);
                }
                var multipleVal = theSelect.val();
                theItem.remove();
                if ((multipleVal != null) && (multipleVal.indexOf(singleVal) !== -1)) {
                    multipleVal.push(singleVal);
                    theSelect.val(multipleVal);
                }
            }
        }

    }
);