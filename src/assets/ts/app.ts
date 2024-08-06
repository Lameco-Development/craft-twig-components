import { Application } from '@hotwired/stimulus';
import Components from './components';

const application = Application.start();

Components.forEach(component =>{
    application.register(component.handle, component.reference);
})
