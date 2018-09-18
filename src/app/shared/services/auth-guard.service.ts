/******************************************************************************************************/
/*	Module name: auth-guard.service.ts																						*/
/* Module description: Service to authenticate user's session prior to accessing profile page				*/
/*	Author: HalfMortise																											*/
/*	Date: 9/18/2018																												*/
/******************************************************************************************************/

/* Imports */

import {Injectable} from "@angular/core";
import {CanActivate, Router} from "@angular/router";
import {AuthService} from "./auth.service";

@Injectable()
export class AuthGuardService implements CanActivate {
	constructor(public auth: AuthService, public router: Router) {}
	canActivate(): boolean {
		if (!this.auth.isAuthenticated()) {
			this.router.navigate([""]);
			return false;
		}
		return true;
	}
}