/******************************************************************************************************/
/*	Module name: about.component.ts																							*/
/* Module description: Behind-the-curtain components populating the front-end of the about page			*/
/*	Author: HalfMortise																											*/
/*	Date: 9/8/2018																													*/
/******************************************************************************************************/

/* Imports */
import {Component} from "@angular/core";
import {Router} from "@angular/router";


/* Component */
@Component({
	template: require("./about.template.html"),
	selector: "about"
})

export class AboutComponent {
	constructor(protected router: Router) {
	}
}