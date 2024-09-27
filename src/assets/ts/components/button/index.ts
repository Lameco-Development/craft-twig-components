import {Controller} from "@hotwired/stimulus"

export default class Button extends Controller {
    connect() {
        console.log(this.element)
    }
}
