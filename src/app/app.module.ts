import {NgModule} from "@angular/core";
import {HttpClientModule} from "@angular/common/http";
import { AngularSplitModule } from 'angular-split';
import {BrowserModule} from "@angular/platform-browser";
import {AppComponent} from "./app.component";
import {allAppComponents, appRoutingProviders, routing} from "./app.routes";
import {ReactiveFormsModule} from "@angular/forms";
import {NguiMapModule} from "@ngui/map";


const moduleDeclarations = [AppComponent];

@NgModule({
	imports:      [AngularSplitModule, BrowserModule, HttpClientModule, NguiMapModule.forRoot({apiUrl: 'https://maps.google.com/maps/api/js?key=AIzaSyBMQE2mPIzXsRIbSUWzBUwiJrdrp80Xkqc'}), routing, ReactiveFormsModule],
	declarations: [...moduleDeclarations, ...allAppComponents],
	bootstrap:    [AppComponent],
	providers:    [...appRoutingProviders]
})
export class AppModule {}