/**
 * Created by romanych on 26.11.15.
 */
describe("pow", function() {

    describe("возводит x в степень n", function() {

        function makeTest(x) {
            var expected = x * x * x;
            it("при возведении " + x + " в степень 3 результат: " + expected, function() {
                assert.equal(pow(x, 3), expected);
            });
        }

        for (var x = 1; x <= 5; x++) {
            makeTest(x);
        }

    });

    it("при возведении в отрицательную степень результат NaN", function() {
        assert(isNaN(pow(2, -1)), "pow(2, -1) не NaN");
    });

    it("при возведении в дробную степень результат NaN", function() {
        assert(isNaN(pow(2, 1.5)), "pow(2, -1.5) не NaN");
    });

    describe("любое число, кроме нуля, в степени 0 равно 1", function() {

        function makeTest(x) {
            it("при возведении " + x + " в степень 0 результат: 1", function() {
                assert.equal(pow(x, 0), 1);
            });


        }

        for (var x = -5; x <= 5; x += 2) {
            makeTest(x);
        }

    });

    it("ноль в нулевой степени даёт NaN", function() {
        assert( isNaN(pow(0, 0)), "0 в степени 0 не NaN");
    });

    describe("Возводит x в степень n", function() {
        it("5 в степени 1 равно 5", function() {
            assert.equal(pow(5, 1), 5);
        });

        it("5 в степени 2 равно 25", function() {
            assert.equal(pow(5, 2), 25);
        });

        it("5 в степени 3 равно 125", function() {
            assert.equal(pow(5, 3), 125);
        });
    });





});

