<?php
 
$FORMS = Array();
 
$FORMS['items'] = <<<END
%items%
END;
 
$FORMS['item'] = <<<END

								Map.areas["area%number%"] = new Map.Area({
									id: %number%,
									name: "Участок №%number%",
									coords:[%coords%],
									html: "<div class=\'map_area_number\'>%number%</div>",
									htmlOver: "%data getProperty(%id%, open_order, place_html_over)%",
									htmlFull: "%data getProperty(%id%, open_order, place_html_full)%",
									fillColor: "%data getProperty(%id%, state, place_fill_color)%",
									strokeColor: "#fff",
									opacity: 0.6,
									opacityOver: 0.9,
									htmlZoom: 16
								});
END;
 
?>