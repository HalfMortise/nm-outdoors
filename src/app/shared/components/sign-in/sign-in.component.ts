/******************************************************************************************************/
/*	Module name: sign-in.component.ts																							*/
/* Module description: Component of a modal that enables a user to sign into profile (page)				*/
/*	Author: HalfMortise																											*/
/*	Date: 9/8/2018																													*/
/******************************************************************************************************/

/* Imports */
import {Component, OnInit} from "@angular/core";
import {SignIn} from "../../interfaces/sign.in";
import {Status} from "../../interfaces/status";
import {SignInService} from "../../services/sign.in.service";
import {Router} from "@angular/router";
import {CookieService} from "ng2-cookies";
import {FormBuilder, FormGroup, Validators} from "@angular/forms";

//declare for JQuery
declare var $: any;

// set the template url and the selector for the ng-powered HTML tag
@Component({
	template: require( "./sign-in.html"),
	selector: "sign-in"
})

export class SignInComponent implements OnInit{
	signInForm: FormGroup;

	signin: SignIn;
	status: Status = null;

	//cookie: any = {};
	constructor(private SignInService: SignInService, private router: Router, private cookieService : CookieService, protected fb: FormBuilder) {
	}

	ngOnInit(): void {
		this.signInForm = this.fb.group({
			email: ["", [Validators.maxLength(128), Validators.required]],
			password: ["", [Validators.maxLength(97), Validators.required]]
		});
	}



	signIn(): void {
		localStorage.removeItem("jwt-token");
		this.SignInService.postSignIn(this.signin).subscribe(status => {
			this.status = status;


			if(status.status === 200) {

				this.router.navigate(["/profile-page"]);

				this.signInForm.reset();
				setTimeout(1000,function(){$("#sign-in-modal").modal('hide');});
			} else {
				console.log("failed login")
			}
		});
	}
}