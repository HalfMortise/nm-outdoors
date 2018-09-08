/******************************************************************************************************/
/*	Module name: sign-up.component.ts																							*/
/* Module description: Component of a modal that enables a user to sign up for a profile (page)			*/
/*	Author: HalfMortise																											*/
/*	Date: 9/8/2018																													*/
/******************************************************************************************************/

/* Imports */
import {Component, NgModule, OnInit} from "@angular/core";
import {FormBuilder, FormGroup, FormsModule, Validators} from "@angular/forms";
import {Status} from "../../interfaces/status";
import {Router} from "@angular/router";
import {SignUpService} from "../../services/sign.up.service";
import {SignUp} from "../../interfaces/sign.up";
import {BrowserModule} from "@angular/platform-browser";



//declare $ for good old jquery
declare let $: any;

//Commenting out for now, as it doesn't seem to have an effect on the "Template parse errors:
// There is no directive with "exportAs" set to "ngForm" "
// @NgModule({
// 	imports: [BrowserModule, FormsModule],
// })

// set the template url and the selector for the ng-powered HTML tag
@Component({
	template: require ("./sign-in-up-modal.html"),
	selector: "sign-up"
})

export class SignUpComponent implements OnInit{

	//
	signUpForm : FormGroup;
	status : Status = {status : null, message: null, type: null};



	constructor(private formBuilder : FormBuilder, private router: Router, private signUpService: SignUpService) {}

	ngOnInit()  : void {
		this.signUpForm = this.formBuilder.group({
			atHandle: ["", [Validators.maxLength(32), Validators.required]],
			email: ["", [Validators.maxLength(128), Validators.required]],
			password:["", [Validators.maxLength(97), Validators.required]],
			passwordConfirm:["", [Validators.maxLength(97), Validators.required]]

		});

		this.status = {status : null, message: null, type: null}

	}

	createProfile(): void {

		let signUp : SignUp = { profileAtHandle: this.signUpForm.value.atHandle, profileEmail: this.signUpForm.value.email, profilePassword: this.signUpForm.value.password, profilePasswordConfirm: this.signUpForm.value.passwordConfirm};

		this.signUpService.createProfile(signUp)
			.subscribe(status => {
				this.status = status;

				if(this.status.status === 200) {
					alert(status.message);
					setTimeout(function() {
						$("#sign-in-up-modal").modal('hide');
					}, 500);
					this.router.navigate([""]);
				}
			});
	}
}