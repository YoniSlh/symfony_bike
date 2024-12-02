import { Application } from "stimulus";
import { definitionsFromContext } from "stimulus/webpack-helpers";

import CartController from './controllers/cart_controller';

const application = Application.start();
application.register("cart", CartController);
