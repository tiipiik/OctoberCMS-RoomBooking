# Booking plugin for OctoberCMS

A simple plugin to manage rooms and bookings for October CMS

## Editing Rooms

The plugin uses the markdown markup for the description of rooms. You can use any Markdown syntax and probably some special tags for embedding images (not tested yet). Globaly, you may prefer adding images via the Featured Images field.

## Implementing front-end pages

The plugin provides several components for building the room list page and room details page (including a booking form)

## Room list page

Use the `roomList` component to display a list of rooms on a page. The component has the following properties:

* **rooms** - a list of rooms loaded from the database.
* **roomPage** - the page witch contains the `roomList` component.
* **roomPageParameterName** - used to create links to each room, should match with the **slugParamName** property of the `roomDetails` component.
* **noRoomsMessage** - contains the value of the `noPostsMessage` component's property.

## Room details page

Use the `roomDetails` component to display details of a room in a page. The component has the following properties:

* **room** - witch contains all the properties of a room, including images.
* **slugParamName** - witch is used to retrieve room based on it's url.

## Extending Room details page

You can add a booking form to the room details page, and only here. This component displays a simple form with informations about the user, arrival and departure dates, and some miscanelious informations. There is also a calendar with non-available dates, so user can easily see when the room is available.

The component has the following properties:

* **redirect** - the page you want the user to be redirected after booking (payment of thank you for example).
* **roomPageParamName** - used to get informations about the room, like booked dates to display in the calendar. This property must be the same that the **slugParamName** property in the `roomDetails`component.

### Issues
Feel free to report any issues at https://github.com/tiipiik/OctoberCMS-RoomBooking

## ToDo List
Front-end:

* add localization,
* return an error when trying to book a room on non-available dates

## License

The Import plugin for OctoberCMS is open-sourced software licensed under the MIT license