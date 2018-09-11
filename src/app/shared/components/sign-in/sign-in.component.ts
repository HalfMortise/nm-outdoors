/******************************************************************************************************/
/*	Module name: sign-in.component.ts																							*/
/* Module description: Component of a modal that enables a user to sign into profile (page)				*/
/*	Author: HalfMortise																											*/
/*	Date: 9/8/2018																													*/
/******************************************************************************************************/

/* Imports */
import {Component, ViewChild} from "@angular/core";
import {SignIn} from "../../interfaces/sign.in";
import {Status} from "../../interfaces/status";
import {SignInService} from "../../services/sign.in.service";
import {Router} from "@angular/router";
import {CookieService} from "ng2-cookies";

//declare for JQuery
declare var $: any;

// set the template url and the selector for the ng-powered HTML tag
@Component ({
	template: require("./sign-in.template.html"),
	selector: "sign-in"
})

export class SignInComponent {
	@ViewChild("signInForm") signInForm: any;

	signin: SignIn = {profileEmail: null, profilePassword: null};
	status: Status = {status: null, type: null, message: null};

	constructor(private SignInService: SignInService, private router: Router, private cookieService : CookieService) {
	}



	signIn(): void {
		localStorage.removeItem("jwt-token");
		this.SignInService.postSignIn(this.signin).subscribe(status => {
			this.status = status;

			console.log(status.status);

			if(this.status.status === 200) {
				this.router.navigate(["/profile-page"]);

			} else {
				alert("Email or password is incorrect. Please try again.")
			}
		});
	}
}