/******************************************************************************************************/
/*	Module name: sign-up.component.ts																							*/
/* Module description: Component of a modal that enables a user to sign up for a profile (page)			*/
/*	Author: HalfMortise																											*/
/*	Date: 9/8/2018																													*/
/******************************************************************************************************/

/* Imports */
import {Component, OnInit} from "@angular/core";
import {FormBuilder, FormGroup, Validators} from "@angular/forms";
import {Status} from "../../interfaces/status";
import {Router} from "@angular/router";
import {SignUpService} from "../../services/sign.up.service";
import {SignUp} from "../../interfaces/sign.up";


//declare $ for good old jquery
declare let $: any;

// set the template url and the selector for the ng-powered HTML tag
@Component({
	template: require ("./sign-up-modal.template.html"),
	selector: "sign-up"
})

export class SignUpComponent implements OnInit{

	//
	signUpForm: FormGroup;
	status: Status = null;



	constructor(
		protected formBuilder : FormBuilder,
		private router: Router,
		private signUpService: SignUpService
	) {}

	ngOnInit() :void {
		this.signUpForm = this.formBuilder.group({
			profileAtHandle: ["", [Validators.maxLength(32), Validators.required]],
			profileEmail: ["", [Validators.maxLength(128), Validators.required]],
			profilePassword:["", [Validators.maxLength(97), Validators.required]],
			profilePasswordConfirm:["", [Validators.maxLength(97), Validators.required]]

		});
	}

	createSignUp(): void {

		let signUp : SignUp = { profileAtHandle: this.signUpForm.value.profileAtHandle, profileEmail: this.signUpForm.value.profileEmail, profilePassword: this.signUpForm.value.profilePassword, profilePasswordConfirm: this.signUpForm.value.profilePasswordConfirm};

		this.signUpService.createProfile(signUp)
			.subscribe(status => {
				this.status = status;

				if(this.status.status === 200) {
					alert(status.message);
					setTimeout(function() {
						$("#sign-up-modal").modal('hide');
					}, 500);
					this.router.navigate(["/profile-page"]);
				}
			});
	}
}