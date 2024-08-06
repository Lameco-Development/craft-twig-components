import {Controller} from "@hotwired/stimulus"
import './index.scss'

export default class Button extends Controller {
    connect() {
        console.log(this.element)
    }
}
