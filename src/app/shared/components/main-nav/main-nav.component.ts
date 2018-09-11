import {Component} from "@angular/core";
import {Router} from "@angular/router";

@Component({
	template: require("./main-nav.template.html"),
	selector: "navigation"
})

export class MainNavComponent{
	constructor(protected router: Router) {
	}
}


