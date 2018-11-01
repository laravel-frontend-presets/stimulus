import { Controller } from "stimulus";

export default class extends Controller {
  greet() {
    console.log(`Hello, ${this.name}!`);
  }

  get name() {
    return this.nameTarget.value;
  }

  static get targets() {
    return [ "name" ];
  }
}
