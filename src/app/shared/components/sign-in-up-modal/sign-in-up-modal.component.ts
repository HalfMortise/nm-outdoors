/******************************************************************************************************/
/*	Module name: profile.component.ts																							*/
/* Module description: Modal component that enables a user to sign up for or sign into profile (page)	*/
/*	Author: HalfMortise																											*/
/*	Date: 9/7/2018																													*/
/******************************************************************************************************/

/* Imports */
import {Component, OnInit} from "@angular/core";
import {SignInService} from "../../services/sign.in.service";
import {Status} from "../../interfaces/status";
import {Profile} from "../../interfaces/profile";
import {ProfileService} from "../../services/profile.service";
import {JwtHelperService} from "@auth0/angular-jwt";
import {SignUpService} from "../../services/sign.up.service";
import {SignUp} from "../../interfaces/sign.up";
import {SignIn} from "../../interfaces/sign.in";


/* Component */

@Component({
	template:`
	<h1>{{profile.profileAtHandle}}</h1>
	
	`
})
export class SignInUpModalComponent implements OnInit{

	profile: Profile;
	status: Status;
	signIn: SignIn;
	signUp: SignUp;

	constructor(private profileService: ProfileService, private jwtHelper : JwtHelperService, private signInService: SignInService, private signUpService: SignUpService) {}

	ngOnInit(): void {
		this.currentlySignedIn()
	}

	currentlySignedIn() : void {

		const decodedJwt = this.jwtHelper.decodeToken(localStorage.getItem('jwt-token'));

		this.profileService.getProfileByProfileEmail(decodedJwt.auth.profileId)
			.subscribe(profile => this.profile = profile)

	}

}


