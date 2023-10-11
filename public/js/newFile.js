<script>
    function copyData(sourceTableId) {
        // Get references to the source and destination tables
    }
        // Get references to the source and destination tables
    var sourceTable = document.getElementById(`source-table-${sourceTableId}`);
    var destinationTable = document.getElementById('destination-table');

    // Get the row from the source table
    var sourceRow = sourceTable.getElementsByTagName('tbody')[0].getElementsByTagName('tr')[0];

    // Clone the row from the source table
    var newRow = sourceRow.cloneNode(true);

    // Append the cloned row to the destination table
    destinationTable.getElementsByTagName('tbody')[0].appendChild(newRow);
    }
</script>;
