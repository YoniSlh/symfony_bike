import { Application } from 'stimulus';
import { definitionsFromContext } from 'stimulus/webpack-helpers';
import { Component as LiveComponent } from '@symfony/ux-live-component';
import { Component as AutocompleteComponent } from '@symfony/ux-autocomplete';

const application = Application.start();

application.register('live', LiveComponent);
application.register('autocomplete', AutocompleteComponent);
