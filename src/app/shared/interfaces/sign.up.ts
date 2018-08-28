/******************************************************************************************************/
/*	Module name: sign.up.ts																										*/
/* Module description: Interface for user to access web app profile sign up service							*/
/*	Author: HalfMortise																											*/
/*	Date: 8/28/2018																												*/
/******************************************************************************************************/

/* Interface */

export interface SignUp {
	profileAtHandle: string,
	profileEmail: string,
	profilePassword: string,
	profilePasswordConfirm: string,
}