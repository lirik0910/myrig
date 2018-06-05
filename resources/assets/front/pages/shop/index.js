import Base from '../../Base.js';

import Header from '../../components/Header';
import Background from '../../components/Background';
import PaperProduct from '../../components/PaperProduct';
import SliderPromo from '../../components/SliderPromo';
import SliderRelated from '../../components/SliderRelated';
import ButtonSendToCart from '../../components/ButtonSendToCart';
import Footer from '../../components/Footer';
import DialogCallback from '../../components/DialogCallback';
import DialogAvailability from '../../components/DialogAvailability';
import ToggleList from '../../components/ToggleList';
import InputProductsCount from '../../components/InputProductsCount';

new Base().call(e => {
	new Header();
	new Background();
	new PaperProduct();
	new SliderPromo();
	new SliderRelated();
	new ButtonSendToCart();

	let inputProductsCount = new InputProductsCount();
	new Footer({ 
		dialogCallback: new DialogCallback({ selector: '#contacts__dialog' }),
		dialogAvailability: new DialogAvailability({ 
			selector: '#availability__dialog',
			toggleList: new ToggleList(),
			inputProductsCount
		})
	});
});