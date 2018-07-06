import Base from '../../Base.js';

import Header from '../../components/Header';
import Background from '../../components/Background';
import Footer from '../../components/Footer';
import DialogTicket from '../../components/DialogTicket';
import DialogCallback from '../../components/DialogCallback';

new Base().call(e => {
	new Header();
	new Background();
	new DialogTicket();
	new Footer({ 
		dialogCallback: new DialogCallback({ selector: '#contacts__dialog' })
	});
});