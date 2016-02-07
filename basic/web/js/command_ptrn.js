/* The Invoker function */
var Switch = function(){
    var _commands = [];
    this.storeAndExecute = function(command){
        _commands.push(command);
        command.execute();
    }
}

/* The Receiver function */
var Light = function(){
    this.turnOn = function(){console.log('turn on')};
    this.turnOff = function(){console.log('turn off')};
}

/* The Command for turning on the light - ConcreteCommand 1 */
var FlipUpCommand = function(light){
    this.execute = light.turnOn();
}

/* The Command for turning on the light - ConcreteCommand 2 */
var FlipDownCommand = function(light){
    this.execute = light.turnOff();
}

var light = new Light();
var switchUp = new FlipUpCommand(light);
var switchDown = new FlipDownCommand(light);
var s = new Switch();
s.storeAndExecute(switchUp);
s.storeAndExecute(switchDown);