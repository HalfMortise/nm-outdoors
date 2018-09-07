/******************************************************************************************************/
/*	Module name: sign-in-up-modal.component.ts																			*/
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
import {Router} from "@angular/router";
import {CookieService} from "ng2-cookies";


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

	//validates user's session when signing in
	currentlySignedIn() : void {

		const decodedJwt = this.jwtHelper.decodeToken(localStorage.getItem('jwt-token'));

		this.profileService.getProfileByProfileEmail(decodedJwt.auth.profileId)
			.subscribe(profile => this.profile = profile)

	}

}


@Component({
	template: require( "./sign-in-up-modal.html"),
	selector: "signinupmodal"
})

export class SignInComponent {
	@ViewChild("signInForm") signInForm: any;

	signin: SignIn = {profileEmail: null, profilePassword: null};
	signup: SignUp = {profileAtHandle: null, profileEmail: null, profilePassword: null, profilePasswordConfirm: null}
	status: Status = {status: null, type: null, message: null};

	//cookie: any = {};
	constructor(private SignInService: SignInService, private SignUpService: SignUpService, private router: Router, private cookieService : CookieService) {
	}



	signIn(): void {
		localStorage.removeItem("jwt-token");
		this.SignInService.postSignIn(this.signin).subscribe(status => {
			this.status = status;

			if(status.status === 200) {

				this.router.navigate(["profile-page"]);

				//location.reload(true);
				this.signInForm.reset();
				setTimeout(1000,function(){$("#sign-in-up-modal").modal('hide');});
			} else {
				console.log("failed login")
			}
		});
	}
}