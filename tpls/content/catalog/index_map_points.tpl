<?php

$FORMS = Array();

$FORMS['items'] = <<<END
%items%
END;
 
$FORMS['item'] = <<<END

					myPlacemark_%id% = new ymaps.Placemark([%data getProperty(%id%, gps_lat, clear)%, %data getProperty(%id%, gps_lng, clear)%], {
						hintContent: '<div class=\'balloonHint\'>%name%</div>',
						balloonContent: '<div class="balloonContent"><div class="image"><img src="%data getProperty(%id%, baloon_image, baloon_image)%" alt="%name%" /></div><div class="description"><div class="name">%name%</div><div class="category">%data getProperty(%id%, category, clear)%</div><div class="place"><span>%data getProperty(%id%, region, clear)%</span></div><div class="text">%data getProperty(%id%, baloon_characters, clear)%</div></div></div>'
					}, {
						iconLayout: 'default#image',
						iconImageHref: mapPointImage,
						iconImageSize: [74, 100],
						iconImageOffset: [-21, -62]
					});
					myMap.geoObjects.add(myPlacemark_%id%);
END;

$FORMS['block_empty'] = <<<END
END;

?>