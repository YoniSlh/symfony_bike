import { Application } from 'stimulus';
import { definitionsFromContext } from 'stimulus/webpack-helpers';

// Crée une instance de l'application Stimulus
const application = Application.start();

// Charge les contrôleurs Stimulus à partir du dossier 'controllers'
const context = require.context('./controllers', true, /\.js$/);
application.load(definitionsFromContext(context));
