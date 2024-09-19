import * as fs from 'fs';

const fetchRoles = async () => {
  const response = await fetch('http://localhost/api/users/roles');
  const data = await response.json();

  return data;
};

const createEnumFileFromRoles = (groups: [string, string][]) => {
  let text = 'enum Roles {\n';
  groups.forEach(([group, roles]) => {
    roles.forEach((role) => {
      text += `  ${role} = '${role}',\n`;
    });
  });

  text += '}\n\n';

  text += 'export default Roles;';

  console.log('Fetching roles and creating enum file');
  return fs.writeFileSync('assets/security/roles.ts', text);
}

fetchRoles().then((data) => createEnumFileFromRoles(Object.entries(data['hydra:member'] || [])));
