import { Application } from '@hotwired/stimulus';
import Button from "./components/button";
import Tooltip from "./components/tooltip";

const application = Application.start();

application.register('button', Button);
application.register('tooltip', Tooltip);
