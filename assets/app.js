import './styles/app.css';
import { startStimulusApp } from '@symfony/stimulus-bridge';
import 'bootstrap';
import './controllers';

startStimulusApp(require.context('./controllers', true, /\.js$/));
