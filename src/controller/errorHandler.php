<?
    class ErrorHandler
    {
        /**
         * Summary of displayError
         * @param mixed $error
         * @return void
         */
        public static function displayError($error)
        {
            echo "<p style='color: red;'>Error: $error</p>";
        }
    }