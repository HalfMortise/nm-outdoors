/******************************************************************************************************/
/*	Module name: sign-up.component.ts																							*/
/* Module description: Component of a modal that enables a user to sign up for a profile (page)			*/
/*	Author: HalfMortise																											*/
/*	Date: 9/8/2018																													*/
/******************************************************************************************************/

/* Imports */



//declare $ for good old jquery
import {Component, OnInit} from "@angular/core";
import {FormBuilder, FormGroup, Validators} from "@angular/forms";
import {Status} from "../../interfaces/status";
import {Router} from "@angular/router";
import {SignUpService} from "../../services/sign.up.service";
import {SignUp} from "../../interfaces/sign.up";

declare let $: any;

// set the template url and the selector for the ng powered html tag
@Component({
	template: require
	("./sign-in-up-modal.html"),
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
			password:["", [Validators.maxLength(48), Validators.required]],
			passwordConfirm:["", [Validators.maxLength(48), Validators.required]]

		});

		this.status = {status : null, message: null, type: null}

	}

	createSignUp(): void {

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