/******************************************************************************************************/
/*	Module name: status.ts																										*/
/* Module description: Interface to allow for any given status to be communicated to user					*/
/*	Author: HalfMortise																											*/
/*	Date: 8/28/2018																												*/
/******************************************************************************************************/

/* Interface */

export interface Status {
	status: number,
	message: string,
	type: string
}